// Function to update the profile picture in the modal
function updateProfilePicture(consultantId, modalId) {
    const modal = document.getElementById(modalId);
    const profilePictureElement = modal.querySelector('.consultant-img');

    const defaultImagePath = 'img/pfp.jpeg';

    if (!consultantId) {
        profilePictureElement.src = defaultImagePath;
        return;
    }

    fetch(`config/authActions.php?request=getconsultantPFP&consultantID=${consultantId}`)
        .then(response => response.text())
        .then(imagePath => {
            if (imagePath && imagePath.trim() !== "") {
                profilePictureElement.src = imagePath;
            } else {
                profilePictureElement.src = defaultImagePath;
            }
        })
        .catch(error => {
            console.error('Error fetching image path:', error);
        });
}

function updateTimeSlotLimit(consultantId){
    const timeInputElement = document.getElementById('booking-time');

    const defaultTime = '';
    if (!consultantId) {
        console.log(`Called timeslot method, no ID`);
        timeInputElement.value = defaultTime;
        timeInputElement.min = defaultTime;
        timeInputElement.max = defaultTime;
        return;
    }

    fetch(`config/authActions.php?request=getworkHours&consultantID=${consultantId}`)
        .then(response => response.text())
        .then(workHours => {
            if (workHours && workHours.trim() !== "") {
                function convertTo24Hour(time12Hour) {
                    let [time, period] = time12Hour.split(/(?=[APap][mM])/);
                    let [hours, minutes] = time.split(':').map(Number);
                    
                    if (period.toLowerCase() === 'pm' && hours !== 12) {
                      hours += 12;
                    } else if (period.toLowerCase() === 'am' && hours === 12) {
                      hours = 0;
                    }
                    
                    let formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
                    return formattedTime;
                  }
                const [start, end] = workHours.split('-').map(time => convertTo24Hour(time.trim()));

                timeInputElement.value = defaultTime;
                timeInputElement.min = `${start}`;
                timeInputElement.max = `${end}`;
            } else {
                timeInputElement.value = defaultTime;
                timeInputElement.min = defaultTime;
                timeInputElement.max = defaultTime;
            }
        })
        .catch(error => {
            console.error('Error fetching work hours:', error);
        });

}

document.addEventListener('DOMContentLoaded', function () {
    const consultantSelect = document.querySelector('#consult-select');
    const addRequestContainer = document.getElementById('add-request-container');
    consultantSelect.addEventListener('change', function () {
        const selectedConsultantId = consultantSelect.value;
        if (addRequestContainer.style.display === 'block') {
            updateProfilePicture(selectedConsultantId, 'add-request-container');
            updateTimeSlotLimit(selectedConsultantId);
        }
    });
});
