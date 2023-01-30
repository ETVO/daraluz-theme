<?php

function daraluz_slides($attrs)
{
    $attrs = shortcode_atts([], $attrs);

    $slides = get_theme_mod('cta_slides');

    $id = 'daraluz_slides_' . random_int(0, 99);

    ob_start(); // Start HTML buffering

?>

    <div class="daraluz_slides carousel slide carousel-fade" id="<?php echo $id; ?>" 
    data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="4000">
        <div class="carousel-inner">
            <?php for ($i = 0; $i < count($slides); $i++) : ?>
                <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                    <?php
                    echo do_shortcode("[insert page='{$slides[$i]['id']}' display='content']");
                    ?>
                </div>
            <?php endfor; ?>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $id; ?>" data-bs-slide="prev">
            <span class="bi-chevron-left" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $id; ?>" data-bs-slide="next">
            <span class="bi-chevron-right" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>

<?php

    foreach ($slides as $slide) :

    endforeach;

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
