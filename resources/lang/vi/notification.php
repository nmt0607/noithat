<?php
return [
    "common" => [
        "success" => [
            "add" => "Thêm mới thành công",
            "update" => "Cập nhật thành công",
            "edit" => "Chỉnh sửa thành công",
            "destroy" => "Hủy thành công",
            "delete" => "Xóa thành công",
            "report-broken" => "Báo hỏng thành công",
            'delete_department_success'=>'Xóa phòng ban thành công',
            "restore" => "Khôi phục thành công",
            "update-status" => "Cập nhật trạng thái thành công",
            "import" => "Import thành công",
            "duplicate" => "Copy thành công",
            "submit_plan"=>'Nộp kế hoạch thành công',
            "aprove"=>"Duyệt nội dung thành công",
            "submit_approve"=>"Nộp phê duyệt thành công",
            'send_approval' => 'Gửi phê duyệt thành công',
            "submit_proposal" => "Gửi đề xuất thành công",
            "submit_topic" => "Nộp đề tài thành công",
            "configure" => "Cấu hình thành công",
            "turned_off_notification" => "Đã tắt thông báo :name",
            "turned_on_notification" => "Đã bật thông báo :name",
            'confirmed'=>'Phê duyệt thành công'
        ],
        "fail" => [
            "invalid_data" => "Thông tin nhập vào không hợp lệ hoặc bị thiếu. Vui lòng thử lại",
            "no-data" => "Không tìm thấy bản ghi nào",
            "no-data-selected" => "Chưa có bản ghi nào được chọn",
            "no-device-selected" => "Bạn chưa chọn thiết bị nào",
            "add" => "Thêm mới thất bại",
            "update" => "Cập nhật thất bại",
            "report_broken" => "Báo hỏng thất bại",
            "restore" => "Khôi phục thất bại",
            "delete" => "Xóa thất bại",
            "delete_parent" => "Không thể xóa Danh mục có chứa danh mục con",
            "update-status" => "Cập nhật trạng thái thất bại",
            "import" => "Import thất bại",
            "no_menu" => "Bạn chưa chọn menu nào",
            "propose_number" => "Số lượng đề xuất hiện tại đang nhỏ hơn số lượng thực tế đã phân công",
            "no_department_code" =>  "Chưa chọn phòng ban",
            "duplicate" =>  "Copy thất bại",
            "select_nothing"=>"Chưa chọn dòng nào",
            "submit_fail"=>'Nộp kế hoạch thất bại,vui lòng cập nhật nhiệm vụ',
            "delete_mission"=>"Xóa thất bại, vui lòng xóa nhiệm vụ con trước",
            "access_error"=>"Lỗi quyền truy cập",
            "warning"=>"Cảnh báo",
            "access_warning"=>"Tài khoản của bạn không có quyền quy cập chức năng này, liên hệ Admin để được hỗ trợ.",
            "error_404"=>'Lỗi 404',
            "disconect_error"=>"Lỗi kết nối",
            'user_info_not_exist' => 'Thông tin nhân sự không tồn tại',
            'not_found'=>'Trang bạn đang tìm không có sẵn hoặc không thuộc trang web này!',
            //

            "delete_department_has_children" => 'Không được phép xóa phòng ban đang chứa phòng ban con',
            "delete_department_has_user" => 'Không được phép xóa phòng ban đang có nhân sự',
            //
            "no_delete_permission" => "Bạn không có quyền xóa",
            'unique_data' => 'Dữ liệu đã tồn tại',
            'importError' => 'File tải lên sai định dạng mẫu',
            "submit_approve"=>"Nộp phê duyệt thất bại",
            'limit_total_file' => 'Chỉ cho phép tải tối đa :limit_total_file file',
            'limit_type_file' => 'Chỉ cho phép tải những file có phần mở rộng sau: :type_file',
            'limit_size_file' => 'Chỉ cho phép tải những file có dung lượng thấp hơn: :size_file',
            'no_delete_has_mark'=>'Không được xóa tài sản đã tạo phiếu',
            'no_delete_confirm'=>'Không được xóa tài sản đã được duyệt',
            'no_edit'=>'Không thể chỉnh sửa ngân sách ở trạng thái này',
            'no_confirmed'=>'Không thể thực hiện phiếu đã được xác nhận'
        ],
        'warning' =>[
            'nothing_select'=>'Bạn chưa chọn bản ghi nào',
            'can_not_edit'=>'Đang chờ phê duyệt không được sửa',
            'delete' => 'Bạn có chắc chắn muốn xoá dữ liệu này không?'
        ],
    ],
    "member" => [
        "warning" => [
            "delete_member" => "Bạn không thể xóa nhân sự :member_name do :member_name đang tham gia lịch sản xuất :record_plan_name",
            "delete_list_members" => "Có nhân sự đang tham gia lịch sản xuất. Vui lòng kiểm tra lại",
            "delete_device" => "Bạn không thể xóa thiết bị :device_name do thiết bị đang tham gia lịch sản xuất :record_plan_name",
            "delete_list_devices" => "Có thiết bị đang tham gia lịch sản xuất. Vui lòng kiểm tra lại",
            "reallocate_device" => "Lịch sản xuất :record_plan_name cần phân công lại thiết bị.",
            "reallocate_member" => "Lịch sản xuất :record_plan_name cần phân công lại nhân sự.",
            "warning-delete?" =>"Bạn có muốn xóa phòng ban này khỏi hệ thống không ?",
            "warning_delete?" =>"Bạn có muốn xóa người dùng này khỏi hệ thống không ?",
            "warning"=>'Cảnh báo',
            "warning-1"=>"Bạn có chắc chắn muốn xóa không? Thao tác này không thể phục hồi!",
            "Do you want to export excel file?" =>"Bạn có muốn xuất file không?",
            "warning_topic"=>'Bạn có chắc chắn muốn xoá đề tài này không?',
            "warning_mission"=>'Bạn có muốn xóa nhiệm vụ này không ?',
            'warning-delete-expert' => 'Bạn có muốn xóa chuyên gia này khỏi hệ thống?',
            "warning_salary"=>"Nhân viên chưa được khai báo Lương cơ sở - Vui lòng kiểm tra lại Hợp đồng lao động"
        ]
    ],
    "asset"=>[
        "success"=>[
            "repair_success"=>"Báo sửa chữa thành công",
            "maintain_success"=>"Báo bảo dưỡng thành công",
            "lost_success"=>"Báo mất thành công",
            "cancle_success"=>"Báo hư hỏng thành công",
            "liquidation_success"=>"Báo thanh lý thành công",
        ],
    ],
    "assignment" => [
        "success" => [
            "add-note" => "Thêm ghi chú thành công",
            'add' => [
                "member" => "Phân công nhân sự thành công",
                "device" => "Phân công thiết bị thành công"
            ],
            "delete" => [
                "member" => "Xóa phân công nhân sự thành công",
                "device" => "Xoá phân công thiết bị thành công"
            ],
            "accept" => [
                "device" =>  "Phê duyệt thiết bị thành công"
            ],
            "propose_device" => [
                "delivered" => "Giao thiết bị thành công",
                "returned" => "Nhận lại thiết bị thành công"
            ]
        ],
        "fail" => [
            "add-note" => "Thêm ghi chú thất bại",
            'add' => [
                "member" => "Phân công nhân sự thất bại",
                "device" => "Phân công thiết bị thất bại"
            ],
            "delete" => [
                "member" => "Xóa phân công nhân sự thất bại",
                "device" => "Xoá phân công thiết bị thất bại"
            ],
            "accept" => [
                "device" =>  "Phê duyệt thiết bị thất bại"
            ],
            "exceed" => "Lịch sản xuất chỉ cần :proposalNumber :department",
            "shortage" => "Lịch sản xuất cần :proposalNumber :department",
            "deliver_device" => "Thiết bị chưa sẵn sàng trong kho, bạn không thể cấp cho lịch :record_plan_name"
        ]
    ],
    "device_category" => [
        "hasItem" => "Không thể xóa danh mục có chứa thiết bị"
    ],
    "record_plan" => [
        "statusCannotDel" => "Không thể xóa lịch sản xuất đang ở trạng thái đã chốt/đang diễn ra/đóng máy/hoàn thành",
        "notYetTime" => "Chưa đến giờ bắt đầu lịch sản xuất",
        "notEnoughPeople" => "Lịch sản xuất chưa đầy đủ nguồn lực"
    ],
    "update_status_record_plan" => [
        1 => [
            "success" => "Phục hồi lịch sản xất thành công",
            "fail" => "Phục hồi lịch sản xuất thất bại"
        ],
        3 => [
            "success" => "Bắt đầu lịch sản xất thành công",
            "fail" => "Bắt đầu lịch sản xuất thất bại"
        ],

        4 => [
            "success" => "Đóng máy thành cônng",
            "fail" => "Đóng máy thất bại"
        ],

        5 => [
            "success" => "Đã hoàn thành lịch sản xuất",
            "fail" => "Lịch sản xuất chưa hoàn thành"
        ],

        -1 => [
            "success" => "Hủy lịch thành công",
            "fail" => "Hủy lịch thất bại"
        ]
    ],
    'role' => [
        'text_error_delete' => 'Vai trò đang được gán cho user',
        'text_error_delete_function' => 'Vai trò đang được gán cho chức năng',
        'warning_delete' => 'Bạn có muốn xóa vai trò này khỏi hệ thống không?'
    ],
    'appraisal' => [
        'chairman_already_exists' => 'Đã tồn tại chủ tịch hội đồng',
        'not_send' => 'Chưa gửi giấy mời',
        'select_full' => 'Chọn đầy đủ thông tin thành viên',
        'delete_member_confirm' => 'Bạn có muốn chắc chắn xóa thành viên này không?',
        'send' => 'Đã gửi giấy mời',
        'accept' => 'Nhận lời',
        'reject' => 'Từ chối',
        'send_success' => 'Gửi giấy mời thành công',
        'error_file_upload' => 'Đính kèm tối đa 5 file',
        'error_delete_appraisal' => 'Bạn không thể xóa hội đồng thẩm định.',
    ],
    'profile' => [
        'success_change_pass' => 'Đổi mật khẩu thành công',
        'size_image' => 'Dung lượng ảnh tối đa 2Mb',
    ],
    'user' => [
        'actions' => [
            'create' => 'thêm',
            'update' => 'cập nhật',
            'delete' => 'xoá',
            'approve' => 'phê duyệt',
            'reject' => 'từ chối'
        ],

        'abnormal_login' => 'Phát hiện việc đăng nhập bất thường với tài khoản của bạn',
        'new_user_info' => ':name đã được thêm vào danh sách nhân sự trong hệ thống',
        'module_data_change' => ':name đã :action :model_type :model_value',
        'personal_work' => 'Bạn đã được thêm vào :model_type :model_value',
        'work_result' => ':model_type :model_value vừa được :action',
        'out_of_date' => 'Đã quá hạn nộp',
        'delivering' => 'Đơn hàng :name sẽ được giao vào ngày :date'
    ],
    'approval' => [
        'warning_delete' => 'Bạn có muốn xóa xét duyệt này khỏi hệ thống không?',
        'select_ideal' => 'Chọn Ý tưởng',
        'create_appraisal' => 'Bạn cần lập hội đồng thẩm định',
    ],
    'topic_fee' => [
        'clear_detail' => 'Bạn có chắc chắn muốn xóa dữ liệu chi tiết?',
        'submit_topic_fee' => 'Nộp dự toán thành công'
    ],
    'finance' => [
        'error_file' => 'Đường dẫn không chính xác hoặc file cài không tồn tại'
    ],

    'upload' => [
        'maximum_uploads' => 'Quá nhiều tệp đính kèm, hãy tải lên tệp .zip hoặc .rar',
        'mime_type' => 'Tệp đính kèm phải là một trong số định dạng: :values',
        'maximum_size' => 'Kích thước tệp phải nhỏ hơn :value Mb'
    ]
];
