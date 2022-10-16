<script>
    const selectClass = (val) => {
        $.ajax({
            url: "<?= $config['base_url']; ?>/app/Services/getAllUserByClassService.php",
            method: "POST",
            dataType: "html",
            data: {
                id_class: val,
            },
            success: function(result) {
                $("#friend").empty();
                $("#friend").append(result);
            },
            error: function(result) {
                alert(result.responseText);
            },
        });
    };
</script>