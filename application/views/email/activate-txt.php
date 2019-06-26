<<<<<<< HEAD
Welcome to <?php echo $site_name; ?>,

Thanks for joining <?php echo $site_name; ?>. We listed your sign in details below, make sure you keep them safe.
To verify your email address, please follow this link:

<?php echo site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?>


Please verify your email within <?php echo $activation_period; ?> hours, otherwise your registration will become invalid and you will have to register again.
<?php if (strlen($username) > 0) { ?>

Your username: <?php echo $username; ?>
<?php } ?>

Your email address: <?php echo $email; ?>
<?php if (isset($password)) { /* ?>

Your password: <?php echo $password; ?>
<?php */ } ?>



Have fun!
=======
Welcome to <?php echo $site_name; ?>,

Thanks for joining <?php echo $site_name; ?>. We listed your sign in details below, make sure you keep them safe.
To verify your email address, please follow this link:

<?php echo site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?>


Please verify your email within <?php echo $activation_period; ?> hours, otherwise your registration will become invalid and you will have to register again.
<?php if (strlen($username) > 0) { ?>

Your username: <?php echo $username; ?>
<?php } ?>

Your email address: <?php echo $email; ?>
<?php if (isset($password)) { /* ?>

Your password: <?php echo $password; ?>
<?php */ } ?>



Have fun!
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
The <?php echo $site_name; ?> Team