![image](https://github.com/user-attachments/assets/ff0c3f7d-791e-4384-a091-b7d508d4d0d0)


FEATURES:

GENERAL: 
    DDoS proof (Ionos domain, 000webhost hosting, cloudflare dns protection)
    Dynamic scalable website
    converts to Hamburger menu when screen is scaled-down
    Light/dark mode
    live chat system for guests and members, merge guest chat to member when user logs in, admin and consultant chat from phone app/website (Crisp API)
    change/delete profile picture (uploaded to local and cloud (imgBB API)), JS to preview pfp change
    day-streak counter
    SQL injection proof

LOG-IN/SIGN-UP SYSTEM:
    Password Reset system using domain Email (uses encrypted token and user selector, SPF, DKIM, DMARC email verification), Local host uses Gmail to send, uses secure selector, token and exipiration
    hashed sensitive info (password, tokens) to prevent data leak
    3 account types: Members, Consultant, Admin
    Google captcha for sign-up
    User authorization and authentication for every page or action
    redirect system to go back to previous page prior to required log-in
    Error handling and input validation
    Admin can assign users the 3 account types

HOME PAGE
    Dynamic Splash screen with Usernames, clickable to skip
    Scrollable animated home screen
    Quotes using JS API (API Ninjas)

FORUM PAGE:
    Create new topics, implemented 3rd party text editor plugin for better UI and UX
    Search topics function
    view topics and reply counts
    able to reply to topics, posts have profile pictures, names, account type, post date and time, JS to instantly update posts
    Consultant names have links to their profile in consultants page
    Admins can delete topics and posts

CONSULTANTS PAGE:
    Search consultants function 
    Admins and consultants can add new consultants: Name, email, phone, work hours, workplace, about consultant, upload profile picture, JS to preview pfp change
    Admins can edit all input fields of consultants, consultant can only edit their own profiles
    Admins can delete consultants
    Users can view consultants info, they can also request specific consultant directly in the consultant's profile: enter contact number, consult date(limits to today and the future), time (system limits time within consultant's work hours), add note


REQUESTS PAGE:
    Request function: 
        search existing requests function
        select consultant from dropdown, search field in dropdown, JS to update preview consultant image
        select member from dropdown, search field in dropdown, JS to update preview member image
        contact number
        consult date, can't book any day before today
        consult time, timeslot within the selected consultant's workhours
        add additional notes

    Admin: 
        make new requests
        assign users to consultants
        view all requests and all requests information, and member's contact number
        can edit all fields of requests
        approve, reject or delete request

    Consultants:
        view requests information requested to this account, and contact no of member
        approve or reject own incoming requests

    Members: 
        view requests information that this account sent out, and contact no of consultant
        make new requests
        delete own request
