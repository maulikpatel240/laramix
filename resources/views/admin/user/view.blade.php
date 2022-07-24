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
        'panel',
        'first_name',
        'last_name',
        'username',
        'email',
        [
            'label' => 'Email verify',
            'value' => function ($model) { // You can set 'value' as a callback function to get a row data value dynamically.
                return $model->email_verified == 1 ? 'Verified' : 'Not Verify';
            },
            'format' => 'html', // To render row content without lossless of html tags, set 'html' formatter.
        ],
        'phone_number',
        [
            'label' => 'Phonenumber verify',
            'value' => function ($model) { // You can set 'value' as a callback function to get a row data value dynamically.
                return $model->email_verified == 1 ? 'Verified' : 'Not Verify';
            },
            'format' => 'html', // To render row content without lossless of html tags, set 'html' formatter.
        ],
        'gender',
        'date_of_birth',
        'address',
        'street',
        'suburb',
        'state',
        'postcode',
        'description',
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
