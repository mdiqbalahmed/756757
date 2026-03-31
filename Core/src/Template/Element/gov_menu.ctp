<script>
    $(document).ready(function() {
        $('#gov_menu-wrap').prepend('<div id="menu-trigger"><i class="fa fa-bars mr-2"></i>Menu</div>');
        $('#menu-trigger').on('click', function() {
            $('.gov_menu').slideToggle();
        });
    });
</script>
<div style="display: flex;align-items: center;max-width: 100%;justify-content: space-evenly;background: #fafafa; margin-bottom:0.5em">
    <div class="mobile_none" style="max-width: 5%;display: flex;justify-content: flex-end;">
        <a href="./"><i class="fa fa-2x fa-home" style="color: #737373"></i></a>
    </div>
    <div style="max-width: 95%; width:100%">
        <nav id="gov_menu-wrap">
            <?= $this->Menus->menu('main', [
                'class' => '',
                'dropdown' => true,
                'dropdownClass' => 'gov_menu',
                'subTagAttributes' => [
                    'class' => 'nav-item',
                ],
                'linkAttributes' => [
                    'class' => 'nav-link',
                ],
            ]); ?>
        </nav>
    </div>


    <script>
        var elementsWithBgDarkClass = document.querySelectorAll(".bg-dark");
        var elementsWithDropdownClass = document.querySelectorAll(".dropdown-toggle");

        // Function to remove classes based on screen size
        function removeClassesBasedOnScreenSize() {
            if (window.innerWidth < 700) {
                var elementsWithNavItemClass = document.querySelectorAll(".nav-item");
                var elementsWithNavLinkClass = document.querySelectorAll(".nav-link");

                elementsWithNavItemClass.forEach(function(element) {
                    element.classList.remove("nav-item");
                });

                elementsWithNavLinkClass.forEach(function(element) {
                    element.classList.remove("nav-link");
                });
            }
        }


        elementsWithBgDarkClass.forEach(function(element) {
            element.classList.remove("bg-dark");
            element.classList.remove("dropdown-menu");
            element.classList.remove("dropdown-item");
        });
        elementsWithDropdownClass.forEach(function(element) {
            element.classList.remove("dropdown-toggle");
        });

        // Call the function on page load and when the window is resized
        removeClassesBasedOnScreenSize();

        window.addEventListener("resize", removeClassesBasedOnScreenSize);
    </script>
