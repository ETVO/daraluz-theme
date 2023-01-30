import 'bootstrap';

/** 
 * Front-end scripts
 * 
 * @package WordPress
 * @author Estevão Rolim <ETVO@github.com>
 */

 (jQuery)(
    function($) {

        /**
         * Set SVG view box to clear white space 
         * 
         * @since 1.0
         */
        function setSVGViewBox() {
            // Get all SVG objects in the DOM
            var svgs = document.getElementsByTagName("svg");

            // Go through each one and add a viewbox that ensures all children are visible
            for (var i=0, l=svgs.length; i<l; i++) {

                var svg = svgs[i],
                    box = svg.getBBox(), // Get the visual boundary required to view all children
                    viewBox = [box.x, box.y, box.width, box.height].join(" ");

                // Set viewable area based on value above
                svg.setAttribute("viewBox", viewBox);
            }
        }

        /**
         * Generate .carousel-indicators buttons for each .carousel
         * 
         * @since 2.0
         */
        function generateCarousel() {
            $(".carousel").each(function() {

                // Don't generate indicators if it already has them 
                // OR if it has them disabled
                var addIndicators = !$(this).find(".carousel-indicators").length 
                    && $(this).attr("data-custom-indicators") != "false";

                var $items = $(this).find(".carousel-item");

                var carouselId = $(this).attr("id");

                var indicators = '<div class="carousel-indicators">';

                try {
                    if($items.length <= 1) {
                        var $prev;
                        if(($prev = $(this).find('.carousel-control-prev').get(0)).length)
                            $prev.hide();
                            
                        var $next;
                        if(($next = $(this).find('.carousel-control-next').get(0)).length)
                            $next.hide();
                    }
                }
                catch(e) {
                    console.error(e);
                }

                for (var i = 0; i < $items.length; i++) {
                    
                    // Get item
                    var item = $items[i];
                    // Check if it is the first one
                    var isFirst = i == 0;

                    // Add active class to item if it is the first one
                    var activeClass = (isFirst) ? "active" : "";
                    $(item).addClass(activeClass);

                    // Create indicator for item
                    var ariaLabel = "Slide " + (i+1);
                    var indicator = '<button';
                    indicator += ' type="button"';
                    indicator += ' data-bs-slide-to="' + i + '"'; 
                    indicator += ' data-bs-target="#' + carouselId + '"'; 
                    indicator += ' aria-label="' + ariaLabel + '"'; 
                    indicator += ' aria-current="true"'; 
                    indicator += ' class="' + activeClass + '"';
                    indicator += '></button>';

                    // Add indicator to indicators
                    indicators += indicator;
                }

                // Close indicators div
                indicators += '</div>';

                // Append indicators to carousel only if it is to be added
                if(addIndicators)
                    $(this).append(indicators);
            })
        }


        function toggleCarouselInner() {
            $(window).on('load resize', function() {
                $('.carousel').each((index, elem) => {
                    $(elem).find('.carousel-inner.d-toggle').each((index, elem) => {
                        content = elem.innerHTML; 

                        if($(elem).is(':visible')) {
                            if(content.substring(0, 4) == '<!--') {
                                elem.innerHTML = content.substring(4, content.length - 4);
                            }
                        }
                        else {
                            if(content.substring(0, 4) != '<!--') {
                                elem.innerHTML = '<!--' + content + '-->';
                            }
                        }
                    });
                });
            });
        }

        /**
         * Logic for multi item carousel
         */
        function multiItemCarousel() {
            let items = document.querySelectorAll('.multi-carousel .carousel-item')

            items.forEach((el) => {
                const minPerSlide = $(el).attr("data-custom-slides") || 3;
                let next = el.nextElementSibling;
                for (var i=1; i<minPerSlide; i++) {
                    if(next == el) return;
                    if (!next) {
                        // wrap carousel by using first child
                        next = items[0]
                    }
                    let cloneChild = next.cloneNode(true)
                    el.appendChild(cloneChild.children[0])
                    next = next.nextElementSibling
                }
            })
        }

        /**
         * Invocate functions when document.body is ready 
         */
        $(document.body).ready(function (){
            // setSVGViewBox();
            generateCarousel();
            toggleCarouselInner();
            multiItemCarousel();
        });
    }
)