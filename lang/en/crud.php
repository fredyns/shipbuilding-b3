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

    'shipbuilding_weekly_reports' => [
        'name' => 'Weekly Reports',
        'index_title' => 'Weekly Reports List',
        'new_title' => 'Add Weekly Report',
        'create_title' => 'Add Weekly Report',
        'edit_title' => 'Edit Weekly Report',
        'show_title' => 'Show Weekly Report',
        'inputs' => [
            'week' => 'Week',
            'date' => 'Date',
            'planned_progress' => 'Planned Progress',
            'actual_progress' => 'Actual Progress',
            'summary' => 'Summary',
            'report_file' => 'Report File',
        ],
    ],

    'shipbuilding_shipbuilding_tasks' => [
        'name' => 'Shipbuilding Shipbuilding Tasks',
        'index_title' => 'Shipbuilding Tasks List',
        'new_title' => 'Add Shipbuilding Task',
        'create_title' => 'Add Shipbuilding Task',
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

    'subtasks' => [
        'name' => 'Sub Tasks',
        'index_title' => 'Sub Tasks List',
        'new_title' => 'Add Sub Task',
        'create_title' => 'Add Sub Task',
        'edit_title' => 'Edit Sub Task',
        'show_title' => 'Show Sub Task',
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

    'weekly_reports' => [
        'name' => 'Weekly Reports',
        'index_title' => 'Weekly Reports List',
        'new_title' => 'Add Weekly Report',
        'create_title' => 'Add Weekly Report',
        'edit_title' => 'Edit Weekly Report',
        'show_title' => 'Show Weekly Report',
        'inputs' => [
            'shipbuilding_id' => 'Shipbuilding',
            'week' => 'Week',
            'date' => 'Date',
            'planned_progress' => 'Planned Progress',
            'actual_progress' => 'Actual Progress',
            'summary' => 'Summary',
            'report_file' => 'Report File',
        ],
    ],

    'weekly_report_documentations' => [
        'name' => 'Weekly Report Documentations',
        'index_title' => 'Weekly Report Documentations List',
        'new_title' => 'Add Weekly Report Documentations',
        'create_title' => 'Add Weekly Report Documentation',
        'edit_title' => 'Edit Weekly Report Documentation',
        'show_title' => 'Show Weekly Report Documentation',
        'inputs' => [
            'file' => 'File',
            'name' => 'Name',
        ],
    ],

    'shipbuilding_daily_reports' => [
        'name' => 'Shipbuilding Daily Reports',
        'index_title' => 'Daily Reports List',
        'new_title' => 'Add Daily Report',
        'create_title' => 'Add Daily Report',
        'edit_title' => 'Edit Daily Report',
        'show_title' => 'Show Daily Report',
        'inputs' => [
            'date' => 'Date',
            'week' => 'Week',
            'actual_progress' => 'Actual Progress',
            'morning_weather_id' => 'Morning Weather',
            'morning_humidity_id' => 'Morning Humidity',
            'midday_weather_id' => 'Midday Weather',
            'midday_humidity_id' => 'Midday Humidity',
            'afternoon_weather_id' => 'Afternoon Weather',
            'afternoon_humidity_id' => 'Afternoon Humidity',
            'temperature' => 'Temperature',
            'summary' => 'Summary',
        ],
    ],

    'weathers' => [
        'name' => 'Weathers',
        'index_title' => 'Weathers List',
        'new_title' => 'Add Weather',
        'create_title' => 'Add Weather',
        'edit_title' => 'Edit Weather',
        'show_title' => 'Show Weather',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'humidities' => [
        'name' => 'Humidities',
        'index_title' => 'Humidities List',
        'new_title' => 'Add Humidity',
        'create_title' => 'Add Humidity',
        'edit_title' => 'Edit Humidity',
        'show_title' => 'Show Humidity',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'daily_reports' => [
        'name' => 'Daily Reports',
        'index_title' => 'Daily Reports List',
        'new_title' => 'Add Daily Report',
        'create_title' => 'Add Daily Report',
        'edit_title' => 'Edit Daily Report',
        'show_title' => 'Show Daily Report',
        'inputs' => [
            'shipbuilding_id' => 'Shipbuilding',
            'date' => 'Date',
            'week' => 'Week',
            'actual_progress' => 'Actual Progress',
            'morning_weather_id' => 'Morning Weather',
            'morning_humidity_id' => 'Morning Humidity',
            'midday_weather_id' => 'Midday Weather',
            'midday_humidity_id' => 'Midday Humidity',
            'afternoon_weather_id' => 'Afternoon Weather',
            'afternoon_humidity_id' => 'Afternoon Humidity',
            'temperature' => 'Temperature',
            'summary' => 'Summary',
        ],
    ],

    'daily_report_personnels' => [
        'name' => 'Daily Report Personnels',
        'index_title' => 'Personnels List',
        'new_title' => 'Add Personnel',
        'create_title' => 'Add Personnel',
        'edit_title' => 'Edit Personnel',
        'show_title' => 'Show Personnel',
        'inputs' => [
            'role' => 'Role',
            'present' => 'Present',
            'description' => 'Description',
        ],
    ],

    'daily_report_equipments' => [
        'name' => 'Daily Report Equipments',
        'index_title' => 'Equipments List',
        'new_title' => 'Add Equipment',
        'create_title' => 'Add Equipment',
        'edit_title' => 'Edit Equipment',
        'show_title' => 'Show Equipment',
        'inputs' => [
            'name' => 'Name',
            'quantity' => 'Quantity',
            'remark' => 'Remark',
        ],
    ],

    'daily_report_materials' => [
        'name' => 'Daily Report Materials',
        'index_title' => 'Materials List',
        'new_title' => 'Add Material',
        'create_title' => 'Add Material',
        'edit_title' => 'Edit Material',
        'show_title' => 'Show Material',
        'inputs' => [
            'name' => 'Name',
            'quantity' => 'Quantity',
            'remark' => 'Remark',
        ],
    ],

    'daily_report_activities' => [
        'name' => 'Daily Report Activities',
        'index_title' => 'Activities List',
        'new_title' => 'Add Activity',
        'create_title' => 'Add Activity',
        'edit_title' => 'Edit Activity',
        'show_title' => 'Show Activity',
        'inputs' => [
            'name' => 'Name',
            'pic' => 'PIC',
        ],
    ],

    'daily_report_documentations' => [
        'name' => 'Daily Report Documentations',
        'index_title' => 'Documentations List',
        'new_title' => 'Add Documentation',
        'create_title' => 'Add Documentation',
        'edit_title' => 'Edit Documentation',
        'show_title' => 'Show Documentation',
        'inputs' => [
            'image' => 'Image',
            'remark' => 'Remark',
        ],
    ],

    'shipbuilding_monthly_reports' => [
        'name' => 'Shipbuilding Monthly Reports',
        'index_title' => 'Monthly Reports List',
        'new_title' => 'Add Monthly Report',
        'create_title' => 'Add Monthly Report',
        'edit_title' => 'Edit Monthly Report',
        'show_title' => 'Show Monthly Report',
        'inputs' => [
            'month' => 'Month',
            'planned_progress' => 'Planned Progress',
            'actual_progres' => 'Actual Progres',
            'report_file' => 'Report File',
            'summary' => 'Summary',
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
