$(document).ready(function() {
    function show_textfile_to_box(input_tag_name) {
        len = input_tag_name.length;
        var result = $('input[name="' + input_tag_name + '"]').get(0).files[0];
        console.log(result);
        
        var reader = new FileReader();
        reader.readAsText(result);

        reader.addEventListener('load', function() {
            var raw_input_tag_name = input_tag_name.substring(0, len - 5);
            console.log(reader.result);
            var target = $('textarea[name="' + raw_input_tag_name + '"]').get(0);
            $(target).val(reader.result);
        });
    }

    $(document).on('change', '#ignore_section input[type="file"]', function() {
        var input_tag_name = $(this).get(0).name;
        // console.log(input_tag_name);
        show_textfile_to_box(input_tag_name);
    });
});
