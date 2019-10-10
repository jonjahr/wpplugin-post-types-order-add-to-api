console.log('admin.js');

// eslint-disable-next-line
acf.add_filter('wysiwyg_tinymce_settings', function(mceInit) {
  // Do something to mceInit.
  // https://www.advancedcustomfields.com/resources/javascript-api/#filters-wysiwyg_tinymce_settings
  console.log('wysiwyg_tinymce_settings');

  mceInit.style_formats = [
    { title: 'Heading', block: 'h4' },
    { title: 'Paragraph', block: 'p' },
  ];

  console.log(mceInit);
  // return
  return mceInit;
});
