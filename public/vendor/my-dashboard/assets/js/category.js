$(document).ready(function () {
    // membuat slug
    function generateSlug(value) {
        return value.trim()
            .toLowerCase()
            .replace(/[^a-z\d-]/gi, '-')
            .replace(/-+/g, '-').replace(/^-|-$/g, "");
    }

    //parent category
    $('#select_category_parent').select2({
        theme: 'bootstrap4',
        allowClear: true,
        ajax: {
            url: "{{url('dashboard/categories/select')}}",
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.title,
                            id: item.id
                        }
                    })
                };
            }
        }
    });

    // event: input dari title
    $('#category_title').change(function(e) {
        e.preventDefault();

        let title = $(this).val();
        let parent_category = $('#select_category_parent').val() ?? "";
        $('#category_slug').val(generateSlug(title + " " + parent_category));
    });

    // event: select parent category
    $('#select_category_parent').change(function(e) {
        e.preventDefault();

        let title = $('#category_title').val();
        let parent_category = $(this).val() ?? "";
        $('#category_slug').val(generateSlug(title + " " + parent_category));
    });


});