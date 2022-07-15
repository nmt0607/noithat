<?php
return [
    "common" => [
        "success" => [
            "add" => "Create successfully",
            "edit" => "Edit successfully",
            "update" => "Update successfully",
            "destroy" => "Cancel successfully",
            "delete" => "Delete successfully",
            "report-broken" => "Successfully reported failure",
            "restore" => "Restore successful",
            'delete_department_success'=>'Delete department success',
            "update-status" => "Status update successful",
            "import" => "Import successful",
            "duplicate" => "Copy successful",
            "submit_plan"=>'Submit plan successfully',
            "aprove"=>"Browse content successful",
            "submit_approve"=>"Submit for approval successfully",
            "send_approval" => "Send approval successfully",
            "submit_proposal" => "Submit proposal successfully",
            "submit_topic" => "Submit topic successfully",
            "configure" => "Configure successfully",
            "turned_off_notification" => "Turned off :name notification",
            "turned_on_notification" => "Turned on :name notification",
            'confirmed'=>'Confirm successfully'
        ],
        "fail" => [
            "invalid_data" => 'Some inputs are invalid or empty. Please try again',
            "no-data" => "No records found",
            "no-data-selected" => "No records selected",
            "no-device-selected" => "You have not selected any device",
            "add" => "Create failed",
            "update" => "Update failed",
            "report_broken" => "Report failed",
            "restore" => "Restore failed",
            "delete" => "Delete failed",
            "delete_parent" => "Cannot delete Category containing subcategories",
            "update-status" => "Status update failed",
            "import" => "Import failed",
            "delete_department_has_children" => 'Not permission to delete department that having department child',
            "delete_department_has_user" => 'Not permission to delete department that having user',
            "no_menu" => "You have not selected any menu",
            "propos_number" => "Current number of proposals is smaller than the actual number assigned",
            "no_department_code" => "No department selected",
            "duplicate" => "Copy failed",
            "select_nothing"=>"No lines selected",
            "submit_fail"=>"Plan submission failed, please update quest",
            "delete_mission"=>"Delete failed, please delete the children mission first",
            'unique_data' => 'Data already exists',
            'importError' => 'The uploaded file is in the wrong template format',
            "submit_approve"=>"Submit for approval fail",
            'no_delete_has_mark'=>'No delete the property that created the ticket',
            'no_delete_confirm'=>'No delete the property that confirmed',
            'limit_total_file' => 'Allows uploading up to :limit_total_file files',
            'limit_type_file' => 'Allows uploading files with the following formats: :type_file',
            'limit_size_file' => 'Allows uploading files up to: :size_file',
            "access_error"=>'Access Error',
            "warning"=>"Warning",
            "access_warning"=>"Your account does not have access to this function, contact Admin for support.",
            "error_404"=>'Error 404',
            "disconect_error"=>"Disconect Error",
            'user_info_not_exist' => 'User Information does not exist',
            'not_found'=>'The page you are looking for is not available or doesn’t belong to this website!',
            'no_edit'=>'Budget cannot be edited in this state',
            'no_confirmed'=>'Can not execute confirmed ticket'
        ],
        'warning' =>[
            'nothing_select'=>'You have not selected any records'
        ],
    ],
    "member" => [
        "warning" => [
            "delete_member" => "You cannot delete personnel :member_name because :member_name is participating in the production schedule :record_plan_name",
            "delete_list_members" => "There are personnel participating in the production schedule. Please check again",
            "delete_device" => "You cannot delete device :device_name because it is participating in production schedule :record_plan_name",
            "delete_list_devices" => "There are devices on the production schedule. Please check again",
            "reallocate_device" => "Production schedule :record_plan_name needs device reassignment.",
            "reallocate_member" => "Production schedule :record_plan_name needs to reassign personnel.",
            "warning-delete?" =>"Do you want to delete this department from the system?",
            "warning_delete?" =>"Do you want to remove this user from the system?",
            "warning"=>'Warning',
            "warning-1"=>"Did you delete? This operation cannot be undone!",
            "Do you want to export excel file?" => "Do you want to export the file?",
            "warning_topic"=>'Do you want to remove this topic from the system?',
            "warning_mission"=>'Do you want to delete this quest?',
            'warning-delete-expert' => 'Do you want to delete this expert from the system?',
            "warning_salary"=>"Undeclared employee base salary - Please check the labor contract",
        ]
    ],
    "asset"=>[
        "success"=>[
            "repair_success"=>" Successful repair report",
            "lost_success"=>"Successful lost report",
            "cancle_success"=>"Successful broken report",
            "maintain_success"=>"Successful maintain report",
            "liquidation_success"=>"Successful liquidation report",
        ],
    ],
    "assignment" => [
        "success" => [
            "add-note" => "Add note successfully",
            'add' => [
                "member" => "Successful personnel assignment",
                "device" => "Device assignment successful"
            ],
            "delete" => [
                "member" => "Delete successful personnel assignment",
                "device" => "Delete device assignment successfully"
            ],
            "accept" => [
                "device" => "Device approval successful"
            ],
            "propose_device" => [
                "delivered" => "Delivered the device successfully",
                "returned" => "Return the device successfully"
            ]
        ],
        "fail" => [
            "add-note" => "Add note failed",
            'add' => [
                "member" => "The personnel assignment failed",
                "device" => "Device assignment failed"
            ],
            "delete" => [
                "member" => "Delete failed personnel assignment",
                "device" => "Delete device assignment failed"
            ],
            "accept" => [
                "device" => "Device approval failed"
            ],
            "exceed" => "The production schedule just needs :proposalNumber :department",
            "shortage" => "The production schedule needs :proposalNumber :department",
            "deliver_device" => "The device is not ready in stock, you cannot grant the calendar :record_plan_name"
        ]
    ],
    "device_category" => [
        "hasItem" => "Cannot delete item containing device"
    ],
    "record_plan" => [
        "statusCannotDel" => "Cannot delete production schedule in closed/in progress/closed/completed state",
        "notYetTime" => "It's not time to start production schedule yet",
        "notEnoughPeople" => "The production schedule is not fully resourced"
    ],
    "update_status_record_plan" => [
        1 => [
            "success" => "Successfully restored production schedule",
            "fail" => "Failed production schedule recovery"
        ],
        3 => [
            "success" => "Start production schedule successfully",
            "fail" => "Start production schedule failed"
        ],

        4 => [
            "success" => "Successful shutdown",
            "fail" => "Shutdown failed"
        ],

        5 => [
            "success" => "Production schedule completed",
            "fail" => "Incomplete production schedule"
        ],

        -1 => [
            "success" => "Successful cancellation",
            "fail" => "Cancellation failed"
        ]
    ],
    'role' => [
        'text_error_delete' => 'Role is being assigned by user',
        'text_error_delete_function' => 'Role is being assigned to the function.',
        'warning_delete' => 'Do you want to remove this role from the system?',
    ],
    'appraisal' => [
        'chairman_already_exists' => 'Chairman already exists',
        'not_send' => 'Invitation not sent',
        'select_full' => 'Select full member information',
        'delete_member_confirm' => 'Do you want to be sure to delete this member?',
        'send' => 'Invitation sent',
        'accept' => 'Accept',
        'reject' => 'Reject',
        'send_success' => 'Successfully sent invitation',
        'error_file_upload' => 'Attach up to 5 files',
        'error_delete_appraisal' => 'You cannot delete the appraisal board.',
    ],
    'user' => [
        'actions' => [
            'create' => 'created',
            'update' => 'updated',
            'delete' => 'deleted',
            'approve' => 'approved',
            'reject' => 'rejected'
        ],

        'abnormal_login' => 'We detected something unusual about recent sign-in to your account',
        'new_user_info' => ':name <span class="text-lowercase">was added to system staff list</span>',
        'module_data_change' => ':name <span class="text-lowercase">:action :model_type :model_value</span>',
        'personal_work' => 'You have been added to <span class="text-lowercase">:model_type :model_value</span>',
        'work_result' => ':model_type <span>:model_value has been :action</span>',
        'out_of_date' => 'Out of date',
        'delivering' => 'Your order :name will be delivered at :date'
    ],
    'approval' => [
        'warning_delete' => 'Do you want to delete this review from the system?',
        'select_ideal' => 'Select ideal',
        'create_appraisal' => 'You need to set up an appraisal committee',
    ],
    'topic_fee' => [
        'clear_detail' => 'Are you sure want to delete the data in detail?',
        'submit_topic_fee' => 'Send estimate successfully'
    ],
    'finance' => [
        'error_file' => 'The path is incorrect or the installation file does not exist'
    ],
    'upload' => [
        'maximum_uploads' => 'Too many uploaded file, please upload archive instead',
        'mime_type' => 'The file type must be a file of type: :values',
        'maximum_size' => 'File size must be less than :value Mb'
    ]
];
