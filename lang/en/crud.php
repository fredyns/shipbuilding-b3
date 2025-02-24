<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'ship_types' => [
        'name' => 'Ship Types',
        'index_title' => 'Ship Types List',
        'new_title' => 'Add Ship Type',
        'create_title' => 'Add Ship Type',
        'edit_title' => 'Edit Ship Type',
        'show_title' => 'Show Ship Type',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'shipyards' => [
        'name' => 'Shipyards',
        'index_title' => 'Shipyards List',
        'new_title' => 'Add Shipyard',
        'create_title' => 'Add Shipyard',
        'edit_title' => 'Edit Shipyard',
        'show_title' => 'Show Shipyard',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'shipbuildings' => [
        'name' => 'Shipbuildings',
        'index_title' => 'Shipbuildings List',
        'new_title' => 'Add Shipbuilding',
        'create_title' => 'Add Shipbuilding',
        'edit_title' => 'Edit Shipbuilding',
        'show_title' => 'Show Shipbuilding',
        'inputs' => [
            'cover_image' => 'Cover Image',
            'number' => 'Number',
            'name' => 'Name',
            'description' => 'Description',
            'progress' => 'Progress',
            'ship_type_id' => 'Ship Type',
            'shipyard_id' => 'Shipyard',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ],
    ],

    'shipbuilding_shipbuilding_tasks' => [
        'name' => 'Shipbuilding Tasks',
        'index_title' => 'Shipbuilding Tasks List',
        'new_title' => 'New Shipbuilding task',
        'create_title' => 'Create Shipbuilding Task',
        'edit_title' => 'Edit Shipbuilding Task',
        'show_title' => 'Show Shipbuilding Task',
        'inputs' => [
            'item_type' => 'Item Type',
            'name' => 'Name',
            'description' => 'Description',
            'weight' => 'Weight',
            'progress_options' => 'Progress Options',
            'progress' => 'Progress',
            'target' => 'Target',
            'deviation' => 'Deviation',
        ],
    ],

    'shipbuilding_tasks' => [
        'name' => 'Shipbuilding Tasks',
        'index_title' => 'Shipbuilding Tasks List',
        'new_title' => 'Add Shipbuilding Task',
        'create_title' => 'Add Shipbuilding Task',
        'edit_title' => 'Edit Shipbuilding Task',
        'show_title' => 'Show Shipbuilding Task',
        'inputs' => [
            'shipbuilding_id' => 'Shipbuilding',
            'parent_task_id' => 'Parent Task',
            'item_type' => 'Item Type',
            'name' => 'Name',
            'description' => 'Description',
            'weight' => 'Weight',
            'enable_sub_progress' => 'Enable Sub Progress',
            'progress' => 'Progress',
            'target' => 'Target',
            'deviation' => 'Deviation',
        ],
    ],

    'shipbuilding_task_shipbuilding_tasks' => [
        'name' => 'Shipbuilding Task Shipbuilding Tasks',
        'index_title' => 'Shipbuilding Tasks List',
        'new_title' => 'Add Shipbuilding Task',
        'create_title' => 'Add Shipbuilding Task',
        'edit_title' => 'Edit Shipbuilding Task',
        'show_title' => 'Show Shipbuilding Task',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
            'weight' => 'Weight',
            'enable_sub_progress' => 'Enable Sub Progress',
            'progress' => 'Progress',
            'target' => 'Target',
            'deviation' => 'Deviation',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
