<?php

require_once "lib/helpers.php";

$column = 'last_name';
$direction = 'asc';

$sort = req('sort');
$sort = explode(':', $sort);
if (count($sort) > 1) {
    $column = $sort[0];
    $direction = $sort[1];
}

$data = [
    'qstring' => [
        'last_name' => "?sort=last_name:asc",
        'active' => "?sort=active:asc",
        'line1' => "?sort=line1:asc",
    ],
];
$toggled = $direction === 'asc' ? 'desc' : 'asc';
$data['qstring'][$column] = "?sort={$column}:{$toggled}";

try {
    $data['users'] = getUsersWithLocations([
        'column' => $column,
        'direction' => $direction,
    ]);
    
} catch (Exception $e) {
    $data['errors'][] = "There was an problem loading the Users";
}

$data['page_title'] = 'Employee Directory';
$data['index'] = true;

render($data, function($data) {
?>
    <div class="table responsive">
        <table class="stripped">
            <thead>
                <tr>
                    <th><a href="<?= $data['qstring']['active'] ?>">Active</a></th>
                    <th><a href="<?= $data['qstring']['last_name'] ?>">Employee Name</a></th>
                    <th><a href="<?= $data['qstring']['line1'] ?>">Location</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($data['users'])) : ?>
                <tr>
                    <td colspan="4" align="center">
                        No Employees Found!
                        Create one <a href="/employees/add.php">here</a>
                    </td>
                </tr>
            <?php endif ?>
            <?php foreach($data['users'] as $user): ?>
                <tr 
                    <?= $user->active ? '' : ' class="user-inactive" ' ?>
                    
                >
                    <td><?= $user->active ? 'Yes' : 'No' ?></td>
                    <td><?= _esc($user->last_name)?>, <?= _esc($user->first_name) ?></td>
                    <td><?= formatLocation($user) ?></td>
                    <td>
                        <a href="/employees/edit.php?user_id=<?= $user->id ?>">edit</a>
                        | <a href="/employees/delete.php?user_id=<?= $user->id ?>">delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php
});
