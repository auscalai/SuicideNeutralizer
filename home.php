<?php include('config/app.php');?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/home.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="scroll-out-master/dist/scroll-out.min.js"></script>
  <link rel="icon" href="img/logo.png" type="image/x-icon">
  <title>SuicideNeutralizer | Home</title>
  <?php 
    if(!isset($_SESSION['authenticated']) OR $_SESSION['auth_user']['user_type']=="Member"){ ?>
  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="ad6f3143-98ba-4e8e-9f26-855358541a32";(function(){d=document;s=d.createElement("script");s.src="js/client.crisp.chat.js";s.async=1;var firstScript = document.head.getElementsByTagName("script")[0];
firstScript.parentNode.insertBefore(s, firstScript);})();</script>
  <?php }?>
  <style>.crisp-client .cc-tlyw .cc-kxkl .cc-1hqb .cc-gye0 .cc-11uv .cc-15ak .cc-acjo .cc-nmj4 {display:none !important;}</style>
</head>
<body>

<div class="intro">
  <h1 class="logo-header">
      <div style="text-align:center;">
      <span class="piclogo"><img src="img/logo.png" id="splash-logo-img"></span><br>
      <span class="splashlogo">Suicide</span><span class="splashlogo" style="color: #8181f7;">Neutralizer</span><br>
      <?php if(isset($_SESSION['authenticated'])):?>
        <span class="welcome">Welcome back&nbsp; </span><span class="welcome"><a style="color:#FDB0C0;"><?= $_SESSION['auth_user']['user_name']?></a>!</span><br>
        <span class="streak" id="daysSinceSignUpSplash"></span>
      <?php else:?>
        <span class="welcome">Welcome&nbsp;</span><span class="welcome"><a style="color:#FDB0C0;">Guest</a>!</span>
        <span class="streak"></span>
      <?php endif;?>
      </div>
  </h1>
</div>
      <script src="js/splashscreen.js"></script>
  <?php include('config/navbar.php'); ?>

  <section class="intro-section">
  <span><span class="intro-heading1">Suicide</span><span class="intro-heading1" style="color: #8181f7;">Neutralizer</span></span>

  <p style="font-size:clamp(15px, 1.5vw, 30px); color:#d4af37;">The latest forum-sharing and consultant booking site.</p>
  <br><br><br><br><br><br>
  <p id="quotes-text" style="font-size:clamp(10px, 1.5vw, 25px);"></p>
  <br>
  <p id="quotes-author" style="font-size:clamp(5px, 1.5vw, 20px);"></p>
</section>

<section class="content-section" data-scroll>
  <figure class="figure"><img src="img/ribbon.jpg" /></figure>
  
  <div class="content">
    <header class="header">
      <div class="subheading">About Us</div>
      <h2 class="heading">Your Safe Haven<br />for Hope and Healing</h2>
    </header>
    <p class="paragraph">
    Welcome to our suicide prevention website, a sanctuary dedicated to providing a safe and anonymous online space for individuals grappling with suicidal thoughts. We understand the importance of safeguarding your privacy and emotional well-being, which is why we prioritize your safety and anonymity above all else.
    </p>
  </div>
</section>

<section class="content-section" data-scroll>
  <figure class="figure"><img src="img/safespace.jpg" /></figure>
  <div class="content">
    <header class="header">
      <div class="subheading">Our Mission</div>
      <h2 class="heading">Creating a Safe,<br />Anonymous Environment</h2>
    </header>
    <p class="paragraph">
    Our commitment to your safety begins with a fundamental principle: we do not request personal information during registration or login. This ensures that your identity remains protected, even in the event of a data breach. By removing the need for personal details, we create a secure haven free from social stigmas, where you can openly share your thoughts and feelings without fear of direct exposure. Our vigilant administrators also monitor the forums to promptly remove any offensive content, ensuring a non-toxic and supportive environment.    </p>
  </div>
</section>

<section class="content-section" data-scroll>
  <figure class="figure"><img src="img/stopsuicide.jpg" /></figure>
  <div class="content">
    <header class="header">
      <div class="subheading">Our Mission</div>
      <h2 class="heading">Reduce and Prevent<br />Suicidal Thoughts</h2>
    </header>
    <p class="paragraph">
    Our mission extends beyond providing a safe space; we aim to reduce and prevent suicide and self-harm. To facilitate this, we offer a dedicated platform for users to request consultations with mental health professionals. Additionally, we provide a comprehensive directory where you can easily search for and connect with qualified consultants. Eliminating the need to navigate external websites or sign up anew, this feature encourages users to take the critical step of seeking professional help in addressing their suicidal thoughts.    </p>
  </div>
</section>

<section class="content-section" data-scroll>
  <figure class="figure"><img src="img/discussion.jpg" /></figure>
  <div class="content">
    <header class="header">
      <div class="subheading">Our Mission</div>
      <h2 class="heading">Fostering Open Dialogue<br />Through our Forum</h2>
    </header>
    <p class="paragraph">
    We recognize the power of shared experiences and the healing potential of open dialogue. Our forum section allows users to express their thoughts, emotions, and past experiences with suicidal thoughts in a supportive community. By sharing your story and reading about the journeys of others, you can find comfort, understanding, and a sense of belonging. Our forum provides a safe haven for personal reflection and interaction, removing the need to seek alternative, potentially unsafe platforms for sharing your thoughts.    </p>
  </div>
</section>

<section class="content-section" data-scroll>
  <figure class="figure"><img src="img/Ausca.jpg" style="object-position: 70% center;" /></figure>
  <div class="content">
    <header class="header">
      <div class="subheading">Meet Our Founder</div>
      <h2 class="heading">Ausca<br />Lai Meng Hin</h2>
    </header>
    <p class="paragraph">
    Driven by a deeply personal journey, Ausca is the compassionate founder behind this platform. Having faced their own battle with suicidal thoughts, Ausca understands the isolation and pain that often accompany such experiences.
<br>
Through their journey, Ausca recognized the crucial need for a safe, anonymous, and supportive space for individuals facing similar struggles. Their personal transformation, fueled by resilience and the support of mental health professionals, ignited the passion to create this website.
<br>
Ausca believes that sharing one's story can be a powerful catalyst for healing, and it is their hope that this platform serves as a beacon of hope and solace for those who may be in the midst of their own struggles. By providing a space for open dialogue and access to professional consultations, Ausca is dedicated to making a meaningful impact in the lives of those who need it most.    </p>
  </div>
</section>

</body>

</html>
<script src="js/darkmode.js"></script>
<?php 
if(!isset($_SESSION['authenticated']) OR $_SESSION['auth_user']['user_type']=="Member"){ ?>
<script type="text/javascript">
  $crisp = [];
  CRISP_TOKEN_ID = '<?php 
  if(!empty($_SESSION['auth_user']['user_token'])){
    echo $_SESSION['auth_user']['user_token'];
  }else{
    echo "";
  }
  ?>';
  CRISP_WEBSITE_ID = 'ad6f3143-98ba-4e8e-9f26-855358541a32';
  CRISP_RUNTIME_CONFIG = {
    session_merge : true
  };
$crisp.push(["set", "user:nickname", ["<?php if(isset($_SESSION['auth_user']['user_name'])){ echo $_SESSION['auth_user']['user_name'];}else{ echo "Guest";}?>"]]);
$crisp.push(["set", "user:email", ["<?php if(isset($_SESSION['auth_user']['user_email'])){echo $_SESSION['auth_user']['user_email'];}else{echo "NONE";}?>"]]);
$crisp.push(["set", "user:avatar", ["<?php if(isset($_SESSION['auth_user']['imgURL'])){ echo $_SESSION['auth_user']['imgURL'];}else{echo "";}?>"]]);
</script>
<?php }?>

<script>
  console.clear();

ScrollOut({
  cssProps: {
    visibleY: true,
    viewportY: true
  }
});

Splitting({ target: '.heading' });
</script>
<script>
        const words = ["life", "inspirational", "happiness"];

         const randomWord = words[Math.floor(Math.random() * words.length)];

        fetch('https://api.api-ninjas.com/v1/quotes?category=' + randomWord, {
            method: 'GET',
            headers: { 'X-Api-Key': 'nZFSxFCZcts+vgbrO8PR8A==wXbbqILAoLRWR4SE' },
        })
        .then(response => response.json())
        .then(data => {
          const quotes = data.map(quoteObj => `"${quoteObj.quote}"`);
            const authors = data.map(quoteObj => `- ${quoteObj.author}`);
            console.log(quotes);
            console.log(authors);

            const quotesText = document.querySelector('#quotes-text');
            const quotesAuthor = document.querySelector('#quotes-author');

              let wordIndex = 0;
              let charIndex = 0;
              let isDeleting = false;
              const typeEffect = () => {
                  const currentWord = quotes[wordIndex];
                  const currentChar = currentWord.substring(0, charIndex);
                  quotesText.textContent = currentChar;
                  if (!isDeleting && charIndex < currentWord.length) {
                      charIndex++;
                      setTimeout(typeEffect, 50);
                  } else {
                  quotesText.classList.add("stop");
                  setTimeout(()=>{quotesAuthor.textContent = authors;},150);
                  }
              }
              setTimeout(()=>{
                typeEffect();
              },3300)
        })
        .catch(error => {
            console.error('Error: ', error);
        });
</script>