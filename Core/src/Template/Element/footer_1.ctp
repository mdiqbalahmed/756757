<div class="container footer_line mt-5">
    <div class="row">
        <div class="col-md-10 col-12">
            <nav class="navbar navbar-expand-lg navbar-light custom_bg_footer">
                <div class="navbar-light" id="footerNav">
                    <?= $this->Menus->menu('footer', [
                        'dropdown' => true,
                        'subTagAttributes' => ['class' => 'nav-item text-left footer_menu foot_nav',],
                        'linkAttributes' => ['class' => 'nav-link footer_link',],
                    ]); ?>
                </div>
            </nav>
        </div>
        <div class="col-md-2 col-12">
            <div class="company_logo text-right">
                <a href="http://tech-plexus.com/" class="ftrLogo" target="_blank"><?php echo $this->Html->image("/uploads/Home/ftrlogo.png", array("alt" => "TechPlexus Ltd.")); ?></a>
            </div>
        </div>
    </div>

</div>