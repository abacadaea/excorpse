<?php 
$root = "./";
require_once ($root.'/assets/php/base.php');

require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');
require_once ($root.'/assets/php/post.php');
require_once ($root.'/assets/php/userInContest.php');
require_once ($root.'/assets/php/macroContest.php');

require_once ($root.'/assets/display/headerDisplay.php');
?>

<h2>Contest Rules</h2>

<h3>Eligibility</h3>
Any student who has not yet entered college is welcome to compete.

<h3>Format</h3>
Contests consist of 10 problems, arranged roughly in increasing order of difficulty. Contest length will vary.
<br><br>
Contestants may work on and submit answers in any order from the answer submission page. Submissions will be graded automatically and contestants will immediately be notified of the result. Contestants may continue to submit answers for a problem if their answer was incorrect, but will incur a time penalty for each incorrect answer, described in further detail below. Each contestant is only permitted 3 submissions per problem.

All answers are nonnegative integers.

<h3>Scoring</h3>
Problem weights will be specified on the test. Contestants will be ranked based on their total score, but ties will be broken in increasing order of time penalty. 
<br><br>
A contestant's time penalty is calculated as the time of the latest submission(where the time is calculated as the number of minutes from the start of the contest to the contestant's submission), plus 5 minutes for each incorrect submission on a problem solved by the contestant.

<!--COMMENTsum of the times of each correct submission (where the time is calculated as the number of minutes from the start of the contest to the contestant's submission), plus 10 minutes for each incorrect submission on a problem the contestant eventually solved.--> <!--For example, suppose there are two problems on a contest. The first has weight 100, and the second has weight 200. If a contestant solves the second problem in 30 minutes after 2 incorrect submissions and has a single incorrect submission on the first problem, but doesn't solve it, her score is 200 and her time penalty is 30 + 2(10) = 50 minutes (she does not receive a penalty for the incorrect submission on the first problem, because she did not ultimately solve the problem). If a second contestant solves the first problem in 45 minutes after 1 incorrect submission, and the second problem in 20 minutes after 2 incorrect submissions, his score is 100+200 = 300 and his time penalty is 45 + 20 + 3(10) = 95 minutes.-->

<h3>Timer</h3>
A timer is available for each contest in the Contest Naviagation bar on the left.

<h3>Leaderboard</h3>
A live leaderboard will be available during the contest. It can be found <a href="/contests/leaderboard.php">here.</a> <!--Users will be listed by username, not actual name.-->

<h3>Resources</h3>
Only pencil, scratch paper, graph paper, ruler/straightedge, compass, and protractor are allowed on this contest. During the contest, you may not consult anyone about the problems or use any notes, books, or tools other than the ones mentioned above. In particular, calculators, computer programs, and computer applications such as Mathematica and Maple are strictly prohibited.

<h3>Results</h3>
Final results will be posted within a day after the contest. Along with it will be an editorial containing solutions and additional comments about the problems.
<!--
<h3>Rating</h3>
We are in the process of constructing a rating system for this contest.
-->

<h3>Cheating</h3>
Super Linear is intended to be a fun and instructive experience more than an actual competition, so we hope that there will be no cheating during the contests. However, any users caught violating the rules stated above will have their accounts removed and IP addresses permanently banned. 



<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>
