-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2023 at 05:19 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `consultant`
--

CREATE TABLE `consultant` (
  `consultantID` int(11) NOT NULL,
  `consultantName` varchar(255) NOT NULL,
  `consultantEmail` varchar(255) NOT NULL,
  `consultantPhone` varchar(255) NOT NULL,
  `consultantPic` varchar(255) DEFAULT NULL,
  `consultantHours` varchar(255) NOT NULL,
  `consultantPlace` varchar(255) NOT NULL,
  `consultantAbout` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultant`
--

INSERT INTO `consultant` (`consultantID`, `consultantName`, `consultantEmail`, `consultantPhone`, `consultantPic`, `consultantHours`, `consultantPlace`, `consultantAbout`) VALUES
(1, 'Ivan Tan', 'ivantan@gmail.com', '+60181028483', 'img/profile-pics/5b96722587b7e9456747104b135a58c0.png', '9:00AM-10:00PM', 'Sunway University', '<p>Welcome! I\'m Ivan Tan, a licensed mental health consultant committed to empowering you on your journey towards mental and emotional wellness. My approach is rooted in compassion, evidence-based practices, and a deep respect for your unique experiences. Whether you\'re struggling with anxiety, depression, trauma, or life transitions, I\'m here to help you build resilience and discover the strength within you.</p>'),
(2, 'Teoh Yowen', 'yowen@gmail.com', '+60175648391', 'img/profile-pics/d8fd68b0e67b063c37409bdf358de133.jpg', '1:00PM-3:00AM', 'Sunway College', ''),
(3, 'Lai Meng Hin', 'menghin@gmail.com', '+60193729187', 'img/profile-pics/a3ff7312e3a1208b3a4ef10e2d56770c.png', '12:00PM-9:00PM', 'Taylors University', '<p>Hello, I\'m Lai Meng Hin, a dedicated mental health consultant specializing in mindfulness-based approaches and holistic healing. My goal is to guide you towards a balanced and fulfilling life by integrating your mind, body, and spirit. Together, we\'ll explore your challenges, develop mindfulness practices, and work on creating lasting positive changes. I\'m excited to join you on this transformative journey.</p>'),
(4, 'Ausca Lai', 'auscalai@gmail.com', '+60174839275', 'img/profile-pics/9f255774bdf36b75a1adf59057470564.png', '6:00AM-6:00PM', 'INTI', '<p>Hi, I\'m Ausca Lai, a dedicated mental health consultant with a passion for helping individuals navigate life\'s challenges. With&nbsp;5 of experience in the field, I provide a safe and empathetic space for you to explore your feelings, develop coping strategies, and find your path to healing and well-being. I believe in the power of self-discovery and resilience, and I\'m here to support you every step of the way.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE `forum_posts` (
  `post_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_posts`
--

INSERT INTO `forum_posts` (`post_id`, `message`, `topic_id`, `user_id`, `created`) VALUES
(1, '<p>Hey everyone, I know how tough the journey can be, but remember that you\'re not alone. It might feel like you\'re drowning in darkness, but even the tiniest glimmer of hope can light up your path. Reach out to a friend, family member, or a professional &ndash; let them be your guiding light. 🌟</p>', 1, 7, '2023-09-01 08:08:02'),
(2, '<p>Sometimes, taking the first step is the hardest, but it\'s also the most important. Start with something simple &ndash; maybe a walk in nature, listening to your favorite song, or writing down your thoughts. These small actions can help you regain control and build a foundation for your healing journey.</p>', 1, 2, '2023-09-01 08:10:10'),
(3, '<p>To those who might be struggling silently, remember that asking for help is a sign of strength, not weakness. Your feelings are valid, and there are people who genuinely care about your well-being. Reach out to a hotline, a friend, or a therapist. You deserve support and understanding.</p>', 2, 2, '2023-09-01 08:10:43'),
(4, '<p>Hey folks, I wanted to share some coping strategies that have been helping me through tough times. Journaling, mindfulness exercises, and engaging in creative hobbies like painting or playing music have all given me a sense of purpose and relief. Let\'s exchange ideas and support each other on this journey.</p>', 3, 3, '2023-09-01 08:11:39'),
(5, '<p>If you\'re here to find ways to support someone you care about, know that your presence matters. Sometimes, just being there to listen without judgment can make a world of difference. Encourage open conversations, offer a shoulder to lean on, and remind them that they\'re not alone.</p>', 4, 6, '2023-09-01 08:12:09'),
(6, '<p>Healing is not a linear path &ndash; there will be ups and downs, and that\'s okay. Celebrate the small victories, no matter how insignificant they may seem. Remember, progress is about moving forward, even if it\'s just one step at a time.</p>', 5, 5, '2023-09-01 08:13:54'),
(7, '<p>It\'s heartwarming to see how this community comes together to uplift one another. We\'re all fighting our battles, but we\'re stronger when we stand united. Share your stories, offer kind words, and let\'s continue to be a source of hope and support for each other.</p>', 6, 4, '2023-09-01 08:18:09'),
(8, '<p>Taking care of ourselves is crucial during difficult times. Whether it\'s taking a bubble bath, reading a book, or practicing deep breathing, self-care can provide moments of peace and rejuvenation. Let\'s share self-care tips and inspire each other to prioritize our well-being.</p>', 7, 1, '2023-09-01 08:23:39'),
(9, '<p>Hello everyone, I want to share my personal journey of navigating through the darkest moments of my life. There were times when I felt like giving up, but with the support of friends, family, and therapy, I\'ve learned to find rays of hope even in the bleakest times. If you\'re struggling, know that you can come out of this stronger than ever. Reach out, talk about your feelings, and remember that you\'re not alone on this path.</p>', 1, 4, '2023-09-01 10:06:31'),
(10, '<p>In moments of despair, isolation can amplify the pain. Connecting with others who understand can be incredibly healing. Joining support groups, attending therapy, or participating in online forums like this one can create a sense of belonging that reminds us we\'re not alone in our struggles.</p>', 2, 4, '2023-09-01 10:07:04'),
(11, '<p>Negative thoughts can feel overwhelming, but they don\'t define you. One technique that\'s helped me is cognitive reframing &ndash; challenging those negative thoughts with evidence of positive experiences. It\'s not an instant fix, but with practice, it can shift your perspective and empower you to manage your thoughts more effectively.</p>\r\n<p>&nbsp;</p>', 3, 4, '2023-09-01 10:07:29'),
(12, '<p>I\'ve been struggling to find the right way to support my friend. Your words remind me that sometimes, all they need is someone who listens and cares. I\'ll be there for them without judgment and let them know they\'re not alone. 🤗💛</p>', 4, 4, '2023-09-01 10:09:45'),
(13, '<p>Thank you for the reminder that healing isn\'t always a straight line. Some days are better than others, and that\'s okay. Celebrating the small victories helps me see that I\'m making progress, even if it\'s slower than I\'d like. 🌈🌟</p>', 5, 4, '2023-09-01 10:10:01'),
(15, '<p>Thank you for the self-care reminders. It\'s easy to forget to take care of myself, but your post motivates me to set aside time for activities that bring me joy and relaxation. We all deserve a little self-love. 🌸💆&zwj;♂️</p>', 7, 4, '2023-09-01 10:10:31'),
(16, '<p>I love the idea of trying new coping strategies. Writing has always been an outlet for me, and now I\'m curious about exploring other creative hobbies too. Thank you for sharing what works for you &ndash; it\'s inspiring! 📝🎨</p>', 3, 2, '2023-09-01 10:11:56'),
(17, '<p>This hits close to home. My friend is going through a tough time, and I\'ve been unsure about how to be there for them. Your words remind me that my presence and understanding matter more than having all the answers. 🤗💚</p>', 4, 2, '2023-09-01 10:12:08'),
(18, '<p>I needed to hear this today. It\'s easy to get frustrated with setbacks, but your post helps me see that every step forward, no matter how small, is a victory. Thank you for the perspective shift. 🌱🌟</p>', 5, 2, '2023-09-01 10:12:25'),
(19, '<p>Absolutely agree. This forum has been a source of comfort for me too. It\'s heartwarming to connect with others who genuinely understand and care. Let\'s keep supporting each other through the ups and downs. 🤝❤️</p>', 6, 2, '2023-09-01 10:12:35'),
(20, '<p>Self-care often takes a backseat for me, but your suggestions make it feel more attainable. I\'ll try incorporating those small moments of self-love into my routine &ndash; it\'s about time I prioritize myself. Thank you for the inspiration. 🌸💕</p>', 7, 2, '2023-09-01 10:12:51'),
(21, '<p>Thank you for this reminder. Sometimes it feels like hope is slipping away, but knowing that others have found their way out of darkness gives me strength. Let\'s keep holding onto that glimmer of hope together. 🌟🌻</p>', 1, 3, '2023-09-01 10:14:41'),
(22, '<p>Your words resonate deeply with me. Asking for help has always been a challenge, but I know it\'s a step I need to take. Thank you for the encouragement to reach out and connect with others. 🙏❤️</p>', 2, 3, '2023-09-01 10:14:58'),
(24, '<p>This couldn\'t have come at a better time. My sibling is going through a tough time, and I\'ve been unsure of how to offer my support. Your words remind me that being present and listening can make a significant difference. 🤗💛</p>', 4, 3, '2023-09-01 10:15:53'),
(25, '<p>I struggle with being patient with myself when progress feels slow. Thank you for the reminder that healing is a journey, not a destination. Each step forward, no matter how small, is a victory worth celebrating. 🌈🌟</p>', 5, 3, '2023-09-01 10:16:12'),
(26, '<p>Absolutely. This forum has become a safe haven for me, knowing that I\'m not alone in my struggles. Let\'s continue to uplift each other, share our stories, and be a source of strength for one another. 🤝❤️</p>', 6, 3, '2023-09-01 10:16:31'),
(27, '<p>Self-care often takes a backseat, but your suggestions make it seem more achievable. I\'ll commit to incorporating those moments of self-care into my routine, starting with some quiet time for myself today. 🌸💆&zwj;♀️</p>', 7, 3, '2023-09-01 10:16:43'),
(28, '<p>Your message is a ray of sunshine on a cloudy day. It\'s true, sometimes hope feels distant, but your reminder that we\'re not alone in this journey brings comfort. We can draw strength from each other\'s stories and experiences. Let\'s hold onto that glimmer of hope and support one another as we navigate through the darkness. 🌞🌈</p>', 1, 5, '2023-09-01 10:18:38'),
(29, '<p>Your post resonates deeply with me. Asking for help has always been a struggle, but your words encourage me to break down that barrier. I appreciate the reminder that reaching out is a sign of strength, not weakness. I\'ll take that step and connect with a counselor, knowing that there\'s a supportive community here to lean on as well. 🤗🙏</p>', 2, 5, '2023-09-01 10:18:50'),
(30, '<p>I\'m grateful that you\'ve shared these coping strategies. Journaling has been a saving grace for me, and I\'m excited to try incorporating creative hobbies like painting into my routine. Finding healthy outlets to channel my emotions is something I\'ve been searching for, and your suggestions are a wonderful starting point. Thank you for inspiring us all. 📝🎨</p>', 3, 5, '2023-09-01 10:19:07'),
(31, '<p>Your words are a reminder that sometimes the simplest gestures can have the most profound impact. It\'s reassuring to know that just being there to listen without judgment can make a difference. I\'ll make an effort to create a space where my friend feels comfortable sharing, knowing that my support can be a source of solace during their difficult time. 🤝💚</p>', 4, 5, '2023-09-01 10:19:21'),
(33, '<p>Absolutely! This community has been a lifeline for so many of us. Sharing our stories, offering support, and empathizing with one another creates a sense of unity that\'s truly empowering. It\'s heartwarming to witness the compassion and strength that emerge when we come together. Let\'s continue uplifting each other on this shared path. 🌟🤗</p>', 6, 5, '2023-09-01 10:20:02'),
(34, '<p>Thank you for highlighting the importance of self-care. It\'s easy to overlook our own well-being when life gets busy, but your suggestions remind me that taking time for ourselves is essential. I\'ll make an effort to engage in those activities that bring me joy, whether it\'s reading a book, practicing meditation, or going for a leisurely walk. By prioritizing self-care, we\'re better equipped to face challenges head-on. 🌸💕</p>', 7, 5, '2023-09-01 10:20:16'),
(35, '<p>Your words resonate deeply with me. In the midst of darkness, hope can feel elusive, but your reminder that we\'re not alone in this struggle is a powerful beacon of light. Sharing our experiences and supporting each other fosters a sense of camaraderie that\'s truly heartwarming. Let\'s lean on each other and together find strength in the journey towards a brighter tomorrow. 🌄🌈</p>', 1, 6, '2023-09-01 10:22:15'),
(36, '<p>I can\'t express enough gratitude for your post. The vulnerability in reaching out can be daunting, but recognizing that it\'s a sign of strength shifts the perspective. Your words have encouraged me to initiate that conversation with a professional, and I\'m also looking into support groups to further connect with those who understand. Together, we can break down the stigma surrounding seeking help. 🤝🌟</p>', 2, 6, '2023-09-01 10:22:34'),
(37, '<p>Your sharing resonates deeply with me. Journaling has been a lifeline, but your mention of creative hobbies like painting has ignited a spark of curiosity within me. I\'m excited to explore this avenue as a way to channel my emotions and find new depths of self-expression. Your openness is an inspiration that encourages us to seek out new ways to heal and grow. 📚🎨</p>', 3, 6, '2023-09-01 10:22:47'),
(38, '<p>Your words have provided much-needed reassurance. Progress isn\'t always linear, and setbacks are a natural part of the journey. Embracing this reality allows us to appreciate the moments of growth, no matter how small. I\'ve decided to document my journey, acknowledging both the highs and lows, to remind myself of the resilience I\'m cultivating. Thank you for highlighting the beauty in imperfection. 📖🌱</p>', 5, 6, '2023-09-01 10:23:17'),
(39, '<p>I wholeheartedly resonate with your sentiment. This forum has been a lifeline, a virtual haven where we can share our stories without judgment. Witnessing the unwavering support and kindness in this community strengthens my belief in the power of human connection. Let\'s continue to lift each other up, offering a safe harbor for anyone seeking solace and understanding. 🤗🌍</p>', 6, 6, '2023-09-01 10:23:29'),
(40, '<p>Your reminder is a wake-up call for many of us. Self-care often takes a backseat, but incorporating it into our routines is essential for overall well-being. Inspired by your suggestions, I\'ll be setting aside time for self-care activities like journaling, yoga, and spending quality time with nature. Thank you for underscoring the significance of self-nurturing practices. 🌻🌿</p>', 7, 6, '2023-09-01 10:23:43'),
(41, '<p>Your words are a gentle nudge that many of us need to hear. It\'s in those moments of vulnerability that we discover the strength within us. Your encouragement to reach out reminds me that I\'m not alone in this struggle. I\'ve taken the first step by scheduling an appointment with a counselor, and I\'m grateful to have a community like this to share this journey with. Let\'s break the silence and shatter the stigma around seeking help. 🙏❤️</p>', 2, 7, '2023-09-01 10:25:53'),
(42, '<p>Thank you for your openness in sharing your coping strategies. Your mention of creative outlets resonates with me, and I\'m eager to explore painting as a way to channel my emotions. I\'ve also found solace in music and have started playing an instrument again. Let\'s continue to exchange ideas and empower each other to find personalized ways to cope and heal. 🎨🎵</p>', 3, 7, '2023-09-01 10:26:04'),
(43, '<p>Your empathy and understanding shine through your words. It\'s true, supporting someone in their time of need doesn\'t always require grand gestures. Your reminder that a simple presence and a listening ear can create a safe space for them to share is both powerful and reassuring. I\'m committed to being that pillar of support for my friend, offering unwavering encouragement as they navigate their journey. 🤝🤗</p>', 4, 7, '2023-09-01 10:26:18'),
(44, '<p>Your insight into the non-linear nature of healing is invaluable. It\'s easy to become discouraged by setbacks, but your reminder that each step forward, no matter how small, is a victory in itself is truly inspiring. I\'ve decided to celebrate even the tiniest of accomplishments and use setbacks as opportunities for learning and growth. Let\'s embrace the imperfect beauty of our journeys. 🌻🌟</p>', 5, 7, '2023-09-01 10:26:34'),
(45, '<p>Your words are a reminder that self-care isn\'t just a luxury; it\'s a vital aspect of maintaining our well-being. I\'ve decided to establish a self-care routine that encompasses a range of activities, from reading and taking nature walks to practicing meditation. By prioritizing self-nurturing habits, I\'m creating a solid foundation for resilience in the face of life\'s challenges. 🌸💆&zwj;♀️</p>', 7, 7, '2023-09-01 10:26:48'),
(46, '<p>Your sentiment captures the essence of this forum beautifully. The unity we\'ve built through shared experiences and heartfelt support is a testament to the strength of human connection. In a world where isolation can take its toll, having a community that genuinely cares is a lifeline. Let\'s continue to foster an environment of compassion, where everyone\'s story is valued and validated. 🤗🌍</p>', 6, 7, '2023-09-01 10:27:01'),
(47, '<p>Your message truly resonates with the heart of our struggles. The path through darkness can feel isolating, but your words remind us that we\'re part of a supportive community that\'s navigating these challenges together. Amidst the struggles, we\'re united by our experiences and our shared determination to find hope and strength. Let\'s keep reaching out, sharing our stories, and lighting the way for each other. 🌟🌄</p>', 1, 1, '2023-09-01 10:27:54'),
(48, '<p>Your words resonate deeply with me. Reaching out can be a daunting step, but your encouragement reminds us that it\'s an act of courage, a demonstration of our commitment to self-care. Your openness has inspired me to research local support groups where I can connect with others who understand. Together, we can shatter the stigma around seeking help and create a safe space for healing. 🤝🌈</p>', 2, 1, '2023-09-01 10:28:13'),
(49, '<p>Thank you for generously sharing your coping strategies. Your mention of creative hobbies like painting and playing music has sparked my curiosity. I\'m planning to dedicate time each day to exploring these activities as a means of channeling my emotions positively. Your insights remind us that our journey is unique, and we can find solace in discovering what resonates with us personally. 🎨🎵</p>', 3, 1, '2023-09-01 10:28:28'),
(50, '<p>Your words reflect a deep understanding of what it means to provide genuine support. Often, we think we need to have all the answers, but your reminder that active listening and empathy matter most resonates profoundly. I\'m committed to creating a space where my loved ones feel safe opening up, knowing they\'re not alone in their struggles. Your compassion serves as a guiding light for us all. 🤗❤️</p>', 4, 1, '2023-09-01 10:28:42'),
(51, '<p>Thank you for addressing a common struggle on this journey. Progress indeed isn\'t always linear, and setbacks can be discouraging. Your perspective shifts the focus from perfection to growth and resilience. I\'m embracing this mindset and plan to journal about my journey, acknowledging both the challenges and the triumphs along the way. Your wisdom reminds us that every step counts. 📖🌱</p>', 5, 1, '2023-09-01 10:29:01'),
(53, '<p>Your words resonate deeply with the heart of this forum. In a world that can sometimes feel isolating, having a community that truly understands and supports us is invaluable. Your call to continue uplifting and empathizing with each other reinforces the sense of unity that makes this space a source of comfort and strength. Let\'s keep sharing, caring, and inspiring one another. 🌍🤗</p>', 6, 1, '2023-09-01 10:29:35'),
(54, '<p>Your post is a testament to the strength of the human spirit. In times of darkness, it can be so easy to lose sight of hope, but your message reminds us that hope is like a small flame that can be nurtured into a blazing fire. Each of us carries a spark, and when we come together, we can create a beacon of support and encouragement for one another. Let\'s continue to share our stories, offer kind words, and be a source of inspiration for those who may be struggling. Together, we can light up the path towards hope and healing. 🌟🌄</p>', 1, 2, '2023-09-02 15:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE `forum_topics` (
  `topic_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`topic_id`, `subject`, `user_id`, `created`) VALUES
(1, 'Finding Hope in the Darkness', 7, '2023-09-01 08:08:02'),
(2, 'A Reminder to Reach Out', 2, '2023-09-01 08:10:43'),
(3, 'Coping Strategies That Help Me', 3, '2023-09-01 08:11:39'),
(4, 'Supporting a Loved One', 6, '2023-09-01 08:12:09'),
(5, 'Progress, Not Perfection', 5, '2023-09-01 08:13:54'),
(6, 'Finding Strength in Community', 4, '2023-09-01 08:18:09'),
(7, 'Focusing on Self-Care', 1, '2023-09-01 08:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` varchar(255) NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pwdreset`
--

INSERT INTO `pwdreset` (`pwdResetId`, `pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`) VALUES
(16, 'promustdie@gmail.com', 'ffab9422ee9c5d55', '$2y$10$2ARrsFz04mDxDaWcjkzriOYVrBJptNQzLdKEfjwDu6gctuKqQkJ2C', '1694444826');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `requestID` int(11) NOT NULL,
  `consultID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `userPhone` varchar(255) NOT NULL,
  `bookingDateTime` datetime NOT NULL,
  `requestApproval` varchar(255) NOT NULL,
  `note` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`requestID`, `consultID`, `userID`, `userPhone`, `bookingDateTime`, `requestApproval`, `note`) VALUES
(1, 4, 2, '+601113399766', '2023-09-13 10:51:00', 'ACCEPTED', '<p>Hello, Im reaching out to share my struggles with anxiety and panic attacks. Over the past year, Ive been experiencing overwhelming feelings of unease, restlessness, and a constant sense of worry that seems to infiltrate every aspect of my life. These anxious thoughts often trigger sudden and intense panic attacks that leave me feeling breathless, dizzy, and physically drained. These episodes have made it difficult for me to engage in daily activities, social interactions, and even work. Im seeking guidance on managing these symptoms and regaining control over my life.</p>'),
(2, 4, 2, '+601113399766', '2023-09-20 18:00:00', 'PENDING', '<p>Greetings, I wanted to discuss my ongoing battle with depressive episodes and persistent low mood. There are times when I feel completely engulfed by sadness, hopelessness, and a lack of interest in things I used to enjoy. These feelings impact my energy levels, making even simple tasks feel like insurmountable challenges. Additionally, I struggle with disrupted sleep patterns and changes in appetite. Its becoming increasingly hard for me to maintain relationships and fulfill my responsibilities. Im seeking support to better understand these emotions and develop strategies to find relief.</p>'),
(3, 1, 2, '+601113399766', '2023-09-18 10:00:00', 'REJECTED', '<p>Hello, Im reaching out to address my concerns about obsessive-compulsive thoughts and behaviors that have been affecting my daily life. I find myself trapped in a cycle of intrusive and distressing thoughts, which I attempt to alleviate through repetitive behaviors. These rituals are time-consuming and interfere with my ability to focus on tasks or maintain relationships. Its frustrating and distressing, as I feel trapped in a cycle that I cant escape from. Im eager to discuss strategies that could help manage these obsessions and regain a sense of normalcy.</p>'),
(4, 1, 2, '+601113399766', '2023-10-26 17:18:00', 'ACCEPTED', '<p>Hi there, I\'d like to share my experiences dealing with mood swings and emotional instability. There are moments when my mood shifts rapidly from intense highs to overwhelming lows, and I struggle to control my emotions during these times. It\'s affecting my relationships, work, and overall well-being. I feel like I\'m on an emotional rollercoaster, and it\'s becoming increasingly challenging to find stability. I\'m seeking insights on how to manage these mood fluctuations and gain a better understanding of their underlying causes.</p>'),
(5, 3, 2, '+601113399766', '2023-09-22 10:24:00', 'ACCEPTED', '<p>Greetings, I\'m writing to discuss my struggles with social anxiety and the resulting isolation I\'ve been experiencing. In social situations, I feel an intense fear of judgment and negative evaluation by others. This often leads me to avoid social interactions altogether, causing me to miss out on important events and opportunities. The isolation has taken a toll on my mental well-being and self-esteem. I\'m eager to find ways to overcome this anxiety and regain the ability to connect with others in a meaningful way.</p>'),
(6, 3, 2, '+601113399766', '2023-09-29 14:03:00', 'ACCEPTED', '<p>Hello, I\'ve been struggling with anxiety and panic disorder for several years now. These overwhelming feelings of fear and unease seem to come out of nowhere, and they often manifest with physical symptoms like rapid heartbeat, trembling, and shortness of breath. These episodes have been affecting my daily life, making it challenging to concentrate at work or enjoy social interactions. I\'m seeking guidance on managing these symptoms and finding strategies to cope with the unpredictability of panic attacks.</p>'),
(8, 2, 2, '+601113399766', '2023-09-27 12:03:00', 'PENDING', '<p>I\'ve heard great things about your expertise in mental health. I\'m going through a tough time and would like to book a consult session with you.</p>'),
(9, 2, 2, '+601113399766', '2023-11-15 21:06:00', 'ACCEPTED', '<p>A follow up consultation to the first one</p>'),
(13, 4, 3, '+601112233455', '2023-09-13 11:45:00', 'ACCEPTED', ''),
(14, 4, 3, '+601112233455', '2023-10-14 09:43:00', 'ACCEPTED', '<p>Follow up consultation</p>'),
(15, 1, 3, '+601112233455', '2023-09-08 12:00:00', 'ACCEPTED', ''),
(16, 1, 3, '+601112233455', '2023-11-18 11:50:00', 'ACCEPTED', '<p>Following up on the previous consultation</p>'),
(17, 3, 3, '+601112233455', '2023-09-14 14:50:00', 'ACCEPTED', '<p>First consultation to test the waters</p>'),
(18, 3, 3, '+601112233455', '2024-01-18 12:47:00', 'REJECTED', '<p>second consultation</p>'),
(19, 2, 3, '+601112233455', '2023-09-30 21:50:00', 'REJECTED', '<p>late night consultation</p>'),
(20, 2, 3, '+601112233455', '2023-09-04 23:50:00', 'ACCEPTED', '<p>Follow up talk&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `pfp` varchar(255) DEFAULT NULL,
  `registerDate` date DEFAULT NULL,
  `accType` varchar(255) NOT NULL COMMENT 'Member, Consultant, Admin',
  `token` varchar(255) NOT NULL,
  `imgURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Email`, `Password`, `pfp`, `registerDate`, `accType`, `token`, `imgURL`) VALUES
(1, 'SuperAdmin', 'admin@admin.com', '$2y$10$lcW4qGYYwmB91KQJWVHlcebCueyKJR0kyofjrWz8ilzBcxhfDb9.G', 'img/profile-pics/662da727034f2c244ca5e0251c451816.png', '2023-09-01', 'Admin', '7337a7b0-502e-4b9a-a4e1-def695da2e18', 'https://i.ibb.co/mv5vjvn/662da727034f2c244ca5e0251c451816.png'),
(2, 'StayingAlive', 'alive@gmail.com', '$2y$10$uBVFWppu9DCJ6Tryg.pjruYRFOj7th7SXTzyArCLHih7Cg5dwz8ES', 'img/profile-pics/aa5db3393cb37ff1cbc67c03c419a1fc.png', '2023-09-01', 'Member', 'bae8e23a-d2c2-4123-b147-ccede6a34656', 'https://i.ibb.co/ZVX9VPW/5dbc7d396c2df5e221591fbb1067bcc9.png'),
(3, 'MentalHealth<3', 'health@gmail.com', '$2y$10$dh5dS5GrFLfQos.qvSsg7uWrE/HfCCkcwjT0F.e94b3H0VWEn8Oze', 'img/profile-pics/98ece1dfc461c547fa8c512f430816f3.png', '2023-09-01', 'Member', 'ecea4342-2ec3-48ed-9230-f0a9fd4c7efe', 'https://i.ibb.co/GtxWx1X/98ece1dfc461c547fa8c512f430816f3.png'),
(4, 'Ausca Lai', 'auscalai@gmail.com', '$2y$10$nfgjgXbDbETy1QA8YDQ8iuJvJ0BQYV2.88Bnf2sfL0AkBUDiFQjw.', 'img/profile-pics/9b8021130978101e79dee4cab036f49c.png', '2023-09-01', 'Consultant', '519b92f5-a2e1-4081-a417-7fa9a8dd4ca8', 'https://i.ibb.co/X2TmZFX/95c36c20c92392032474f8d1e68f62fe.png'),
(5, 'Lai Meng Hin', 'menghin@gmail.com', '$2y$10$Te8S4.KRRGhBr8ubJ4VLrefa6pKTPC1yi9DY88YmcBo31j2yovLAm', 'img/profile-pics/35d355aa2a63562a824d582763daad25.png', '2023-09-01', 'Consultant', '224cb020-dcaf-4ff2-83a2-9bd86e700604', 'https://i.ibb.co/SRd6yPZ/35d355aa2a63562a824d582763daad25.png'),
(6, 'Teoh Yowen', 'yowen@gmail.com', '$2y$10$bz0e2HIaIJa8Y2q0NvrXjO1BkzbvZSMmn3mIBe3Yd1K7OdUawnSS.', 'img/profile-pics/01c338bcd187fc8fc6cb582027ce2230.jpg', '2023-09-01', 'Consultant', '472c71be-2ef9-4780-ad98-56daaa00e804', 'https://i.ibb.co/grQm7YK/01c338bcd187fc8fc6cb582027ce2230.jpg'),
(7, 'Ivan Tan', 'ivantan@gmail.com', '$2y$10$IuIApsmI1reLo7jMwSok6OGS8dzqddw0gyxtR6tPG.etSiI/9HNqW', 'img/profile-pics/870243be8e628030e616c8b2d8302e96.png', '2023-09-01', 'Consultant', '711cc43f-f9fb-44e4-b4f0-1b346bbf2d62', 'https://i.ibb.co/QfcZ6QR/870243be8e628030e616c8b2d8302e96.png'),
(10, 'ProMustDie', 'ausca33@gmail.com', '$2y$10$Y/Cn2fmdbVZMdsCBxgzapeSQNaKvCklpVsM5bf/w2TI23UDxlxi5e', NULL, '2023-09-11', 'Member', '10b8719e-5ed8-4c44-a093-aa0d01587cf2', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultant`
--
ALTER TABLE `consultant`
  ADD PRIMARY KEY (`consultantID`),
  ADD KEY `consultantID` (`consultantID`),
  ADD KEY `consultantEmail` (`consultantEmail`);

--
-- Indexes for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_id` (`post_id`,`topic_id`,`user_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `topic_id` (`topic_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`),
  ADD KEY `pwdResetEmail` (`pwdResetEmail`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `consultID` (`consultID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultant`
--
ALTER TABLE `consultant`
  MODIFY `consultantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultant`
--
ALTER TABLE `consultant`
  ADD CONSTRAINT `consultant_ibfk_1` FOREIGN KEY (`consultantEmail`) REFERENCES `user` (`Email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `forum_posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `forum_topics` (`topic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `forum_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD CONSTRAINT `forum_topics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`consultID`) REFERENCES `consultant` (`consultantID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
