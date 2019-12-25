<h1>Main Index</h1>
<?= $allPosts[1] ?>
<button class="btn btn-success" data-id="2">Button</button>
<h3></h3>
<script>
$('button').on('click', function(e) {
    e.preventDefault();
    let id = $(this).data("id");

    $.ajax({
        url: '/main/test',
        type: 'post',
        data: {id: id},
        success: function(result) {
            $('h3').text(result);
        }
    });
});
</script>