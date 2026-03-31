<footer class="navbar-dark">
    <div class="navbar-inner">

        <div class="footer-content">
            <?php

            use Cake\Core\Configure;

            $link = $this->Html->link(
                __d('croogo', 'Tech Plexus Ltd.', (string)Configure::read('Croogo.version')),
                'https://tech-plexus.com/'
            );
            ?>
            <?= __d('croogo', 'Powered by %s', $link) ?>
        </div>

    </div>
</footer>
