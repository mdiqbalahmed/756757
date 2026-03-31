<style>
  
 .controller-row > td {
    background: #6f6f6f !important;
    background-color: #555 !important;
    color: #fff !important;
}
 .level-2 > td {
    background: #9e9b9bff !important;
    background-color: #9e9b9bff !important;
    color: #fff !important;
}
 .level-1 > td {
    background: #777 !important;
    background-color: #777 !important;
    color: #fff !important;
}
</style>
<table class="table permission-table">
    <?php
    $roleTitles = array_values($roles->toArray());
    $roleIds = array_keys($roles->toArray());

    $tableHeaders = [
        __d('croogo', 'Id'),
        __d('croogo', 'Alias'),
    ];
    $tableHeaders = array_merge($tableHeaders, $roleTitles);
    $tableHeaders = $this->Html->tableHeaders($tableHeaders);
    ?>

    <thead>
        <?= $tableHeaders ?>
    </thead>

    <?php
    $icon = '<i class="float-right"></i>';
    $currentController = '';
    foreach ($acos as $index => $aco) {
        $id = $aco->id;
        $alias = $aco->alias;
        $class = '';
        if (substr($alias, 0, 1) == '_') {
            $level = 1;
            $class .= 'level-' . $level;
            $oddOptions = ['class' => 'hidden controller-' . $currentController];
            $evenOptions = ['class' => 'hidden controller-' . $currentController];
            $alias = substr_replace($alias, '', 0, 1);
        } else {
            $level = 0;
            $class .= ' controller';
            if ($aco->children > 0) {
                $class .= ' perm-expand';
            }
            $oddOptions = [];
            $evenOptions = [];
            $currentController = $alias;
        }

        $row = [
            $id,
            $this->Html->div(trim($class), $alias . $icon, [
                'data-id' => $id,
                'data-alias' => $alias,
                'data-level' => $level,
            ]),
        ];

        foreach ($roles as $roleId => $roleTitle) {
            $row[] = '';
        }

        echo $this->Html->tableCells($row, $oddOptions, $evenOptions);
    }
    ?>

    <thead>
        <?= $tableHeaders ?>
    </thead>

</table>
