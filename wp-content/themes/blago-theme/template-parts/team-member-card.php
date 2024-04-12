<?php
if ( function_exists('get_field') ):
    $name = get_field('team-name');
    $photo_url = get_field('photo');
    $position = get_field('position');
    $linkedin = get_field('linkedin');
    $email = get_field('email');
    ?>
    <div class="team-member">
        <a href="<?php the_permalink(); ?>">
        <?php if( !empty($photo_url) ): ?>
            <img src="<?php echo $photo_url; ?>" alt="<?php echo $name; ?>" class="team-member-photo">
        <?php endif; ?>
        </a>

        <div class="content-container">
            <a href="<?php  the_permalink();?>">
                <?php if( !empty($name) ): ?>
                    <h3 class="team-member-name"><?php echo $name; ?></h3>
                <?php endif; ?>
            </a>

            <?php if( !empty($position) ): ?>
                <p class="team-member-position"><?php echo $position; ?></p>
            <?php endif; ?>
            <?php if( !empty($email) ): ?>
                <a href="mailto:<?php echo $email; ?>" class="team-member-email">Email: <?php echo $email; ?></a>
            <?php endif; ?>

            <?php if( !empty($linkedin) ): ?>
                <a class="team-member-linkedin" href="<?php echo $linkedin;?>" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 26 26">
                        <path d="M 21.125 0 L 4.875 0 C 2.183594 0 0 2.183594 0 4.875 L 0 21.125 C 0 23.816406 2.183594 26 4.875 26 L 21.125 26 C 23.816406 26 26 23.816406 26 21.125 L 26 4.875 C 26 2.183594 23.816406 0 21.125 0 Z M 8.039063 22.070313 L 4 22.070313 L 3.976563 9.976563 L 8.015625 9.976563 Z M 5.917969 8.394531 L 5.894531 8.394531 C 4.574219 8.394531 3.722656 7.484375 3.722656 6.351563 C 3.722656 5.191406 4.601563 4.3125 5.945313 4.3125 C 7.289063 4.3125 8.113281 5.191406 8.140625 6.351563 C 8.140625 7.484375 7.285156 8.394531 5.917969 8.394531 Z M 22.042969 22.070313 L 17.96875 22.070313 L 17.96875 15.5 C 17.96875 13.910156 17.546875 12.828125 16.125 12.828125 C 15.039063 12.828125 14.453125 13.558594 14.171875 14.265625 C 14.066406 14.519531 14.039063 14.867188 14.039063 15.222656 L 14.039063 22.070313 L 9.945313 22.070313 L 9.921875 9.976563 L 14.015625 9.976563 L 14.039063 11.683594 C 14.5625 10.875 15.433594 9.730469 17.519531 9.730469 C 20.105469 9.730469 22.039063 11.417969 22.039063 15.046875 L 22.039063 22.070313 Z"></path>
                    </svg>
                    LinkedIn
                </a>
            <?php endif; ?>

        </div>


    </div>
<?php endif; ?>
