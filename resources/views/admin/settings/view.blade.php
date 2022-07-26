@detailView([
    'model' => $model,
    // 'title' => 'Detail title', // It can be empty ''
    'htmlAttributes' => [
        'class' => 'table table-bordered table-striped'
    ],
    'captionColumnConfig' => [
        'label' => 'title',
        'htmlAttributes' => [
            'class' => 'th-title-class'
        ]
    ],
    'valueColumnConfig' => [
        'label' => 'value',
        'htmlAttributes' => [
            'class' => 'th-value-class'
        ]
    ],
    'showHead' => false,
    'rowFields' => [
        'business_name',
        'owner_name',
        'business_email',
        'business_phone_number',
        'business_address',
        'salon_type',
        'number_of_staff',
        [
            'label' => 'Active', // Row label.
            'value' => function ($model) { // You can set 'value' as a callback function to get a row data value dynamically.
                return $model->is_active == 1 ? 'Active' : 'Inactive';
            },
            'format' => 'html', // To render row content without lossless of html tags, set 'html' formatter.
        ],
        'is_active_at',
        'created_at',
        'updated_at',
    ]
])