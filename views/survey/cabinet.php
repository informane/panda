<h3 class="text-center mt-3">Survey list</h3>
<div class="col-md-12 col-lg-12 col-xl-10 mx-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Survey List</li>
        </ol>
    </nav>
</div>
<div class="col-md-12 col-lg-12 col-xl-10 mx-auto bg-body-tertiary p-4 rounded">
    <div class="container my-3"><a href="/survey/update"><button type="button" class="btn btn-primary">Create survey</button></a></div>
    <div class="container-lg">
        <div class="row border p-3">
            <div class="col-1">ID</div>
            <div class="col-3"><a href="javascript:void(0)" class="sort" data-sort_field="text">Text</a></div>
            <div class="col-2"><a href="javascript:void(0)" class="sort" data-sort_field="date_created">Date Created</a></div>
            <div class="col-2"><a href="javascript:void(0)" class="sort" data-sort_field="status">Status</a></div>
        </div>
    </div>
    <?php foreach($params['questions'] as $question): ?>
    <div class="container">
        <div class="row border p-3">
            <div class="col-1"><?php echo $question->id ?></div>
            <div class="col-3"><?php echo $question->text ?></div>
            <div class="col-2"><?php echo $question->date_created ?></div>
            <div class="col-2"><?php echo \models\Question::STATUSES[$question->status] ?></div>
            <div class="col-1"><a href="/survey/view?id=<?php echo $question->id ?>"><button class="btn btn-success">View</button></a></div>
            <div class="col-1"><a href="/survey/update?id=<?php echo $question->id ?>"><button class="btn btn-secondary">Edit</button></a></div>
            <div class="col-2"><a href="/survey/remove?id=<?php echo $question->id ?>" class="remove"><button class="btn btn-danger">Remove</button></a></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<script>
    let sort_array=[];
    url = new URL(window.location.href);
    sort_array = url.searchParams.getAll("orderBy[]");
    $('.sort').click(function () {
        let sort_field=$(this).data('sort_field');
        let sort_field_order=sort_array.filter(function (e) {
            let this_sort_field=e.split(' ')[0];
            return this_sort_field===sort_field;
        });

        let sort_order='';
        if(sort_field_order[0]!=null) {
            sort_order = sort_field_order[0].split(' ')[1];
        }
        if(sort_order=='asc') sort_order='desc';
        else if(sort_order=='desc') sort_order='';
        else if(sort_order=='') sort_order='asc';

        sort_array=sort_array.filter(function (e) {
            let this_sort_field=e.split(' ')[0];
            return this_sort_field!==sort_field;
        });
        if(sort_order!=='') {
            sort_array.unshift(sort_field + ' ' + sort_order);
        }

        let sort_params=$.param({orderBy: sort_array});
        window.location='/survey/cabinet?'+sort_params;
    })

    $('.remove').click(function (e) {
        e.preventDefault();
        let ask=confirm('Are you sure you wish to delete this question?');
        if(ask){
            window.location=$(this).attr('href');
        }
    })
</script>
