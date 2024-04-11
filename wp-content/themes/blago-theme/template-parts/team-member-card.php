<?php
if ( function_exists('get_field') ):
    $name = get_field('team-name');
    $photo_url = get_field('photo');
    $position = get_field('position');
    $linkedin = get_field('Linkedin');
    $email = get_field('Email');
    ?>
    <div class="team-member">
        <?php if( !empty($photo_url) ): ?>
            <img src="<?php echo $photo_url; ?>" alt="<?php echo $name; ?>" class="team-member-photo">
        <?php endif; ?>
        <?php if( !empty($name) ): ?>
            <h3 class="team-member-name"><?php echo $name; ?></h3>
        <?php endif; ?>
        <?php if( !empty($position) ): ?>
            <h4 class="team-member-position"><?php echo $position; ?></h4>
        <?php endif; ?>
        <?php if( !empty($linkedin) ): ?>
            <p class="team-member-linkedin"> <a href="<?php echo $linkedin; ?>" target="_blank">LinkedIn</a></p>
        <?php endif; ?>
        <?php if( !empty($email) ): ?>
            <p class="team-member-email">Email: <?php echo $email; ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>
