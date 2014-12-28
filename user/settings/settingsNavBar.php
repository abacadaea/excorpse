<?
    $user = $_COOKIE["HCuser"];
?>

<ul class = "nav nav-pills">
    <li><a href = "/user/"><?php echo $user;?></a></li>
    <li id = 'link-settings-general'><a href = "/user/settings/general">General</a></li>
    <li id = 'link-settings-personal'><a href = "/user/settings/personal">Personal</a></li>
</ul>

