
function startEditor(id) {
	tinymce.init({
		selector: "textarea#"+id,
		plugins: [
			"code ",
			"paste"
		],
		toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  ",
		menubar:false,
		statusbar: false,
		content_style: ".mce-content-body {font-size:15px;font-family:Arial,sans-serif;}",
		height: 200	
	});
}

function startEditor2(id) {
	tinymce.init({
		selector: "textarea#"+id,
		plugins: [
			"code ",
			"paste"
		],
		toolbar: "undo redo | bold italic | bullist numlist outdent indent  ",
		menubar:false,
		statusbar: false,
		content_style: ".mce-content-body {font-size:15px;font-family:Arial,sans-serif;}",
		height: 200	
	});
}


$( document ).ready(function() {
	startEditor('message');	
	$(document).on('submit','#posts', function(event){		
		var formData = $(this).serialize();
		$.ajax({
                url: "action.php",
                method: "POST",              
                data: formData,
				dataType:"json",
                success: function(data) {					
					var html = $("#postHtml").html();
					html = html.replace(/PICTURE/g, data.pfp);
					html = html.replace(/USERNAME/g, data.name);
					html = html.replace(/POSTDATE/g, data.post_date);
					html = html.replace(/POSTMESSAGE/g, data.message);
					html = html.replace(/POSTID/g, data.post_id);
					html = html.replace(/TOPICID/g, data.topic_id);
					html = html.replace(/ACCTYPE/g, data.accType);
					html = html.replace(/EMAIL/g, data.email);
					$(".posts").append(html).fadeIn('slow');
					tinymce.get('message').setContent('');
                }
        });		
		return false;
	});
	
});

$( document ).ready(function() {
	startEditor2('add-note');	
});