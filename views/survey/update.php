<h3 class="text-center mt-5"><?php echo $_GET['id'] == 0 ? 'Create' : ' Update' ?> survey</h3>
<?php $_GET['id'] == 0 ? $action='/survey/update' : $action='/survey/update?id=' . $_GET['id']; ?>
<form action="<?php echo $action ?>" method="post">
    <?php
    $question=$params['question'] ?? null;
    $answers=$params['answers'] ?? [];
    ?>
    <input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?>">
    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/survey/cabinet">Survey List</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $_GET['id'] == 0 ? 'Create' : ' Update' ?></li>

            </ol>
        </nav>
    </div>
    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto bg-body-tertiary p-4 rounded">
        <div class="container">
            <input type="hidden" name="Question[id]" value="<?php echo $question->id ?>">
            <div class="col-sm-12 col-lg-4">
                <label for="Question[status]" class="form-label">Status</label>
                <select name="Question[status]" class="form-select">
                    <?php foreach (\models\Question::STATUSES as $key=>$status): ?>
                        <option value="<?php echo $key ?>" <?php if ($key == ($question->status ?? 1)) echo "selected" ?>><?php echo $status ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($params['questionValidErrors']['status'])): ?><div class="alert alert-danger" role="alert"><?php echo implode('<br/>', $params['questionValidErrors']['status']) ?></div><?php endif; ?>
            </div>
            <h3 class="text-center mt-3">Question</h3>
            <div class="col-12">
                <label for="Question[text]" class="form-label">Text</label>
                <textarea name="Question[text]" class="form-control"><?php echo $question->text ?? '' ?></textarea>
                <?php if (isset($params['questionValidErrors']['text'])): ?><div class="alert alert-danger" role="alert"><?php echo implode('<br/>', $params['questionValidErrors']['text']) ?></div><?php endif; ?>

            </div>

        </div>
        <h3 class="text-center mt-3">Answers</h3>
        <div class="answers container">
            <?php if(count($answers)): foreach ($answers as $i=>$answer): ?>
                <div class="answer row">
                    <input type="hidden" name="Answer[<?php echo $i ?>][id]" value="<?php echo $answer->id ?>">
                    <div class="col-md-6">
                        <label for="Answer[<?php echo $i ?>][text]" class="form-label">Text</label>
                        <input type="text" name="Answer[<?php echo $i ?>][text]" value='<?php echo $answer->text ?>' class="form-control">
                        <?php if (isset($params['answersValidErrors'][$i]['errors']['text'])): ?><div class="alert alert-danger" role="alert"><?php echo implode('<br/>', $params['answersValidErrors'][$i]['errors']['text']) ?></div><?php endif; ?>

                    </div>
                    <div class="col-md-4">
                        <label for="Answer[<?php echo $i ?>][votes_number]" class="form-label">Votes number</label>
                        <input type="number" name="Answer[<?php echo $i ?>][votes_number]" value="<?php echo $answer->votes_number ?>" class="form-control">
                        <?php if (isset($params['answersValidErrors'][$i]['errors']['votes_number'])): ?><div class="alert alert-danger" role="alert"><?php echo implode('<br/>', $params['answersValidErrors'][$i]['errors']['votes_number']) ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-2 mt-4 pt-2">
                        <button class="btn btn-danger remove_answer">Remove</button>
                    </div>
                </div>
            <?php endforeach; else: $i=0; ?>
                <div class="answer row">
                    <input type="hidden" name="Answer[<?php echo $i ?>][id]" value="<?php echo $answer->id ?>">
                    <div class="col-md-6">
                        <label for="Answer[<?php echo $i ?>][text]" class="form-label">Text</label>
                        <input type="text" name="Answer[<?php echo $i ?>][text]" value='<?php echo $answer->text ?>' class="form-control">
                        <?php if (isset($params['answersValidErrors'][$i]['errors']['text'])): ?><div class="alert alert-danger" role="alert"><?php echo implode('<br/>', $params['answersValidErrors'][$i]['errors']['text']) ?></div><?php endif; ?>

                    </div>
                    <div class="col-md-4">
                        <label for="Answer[<?php echo $i ?>][votes_number]" class="form-label">Votes</label>
                        <input type="number" name="Answer[<?php echo $i ?>][votes_number]" value="<?php echo $answer->votes_number ?>" class="form-control">
                        <?php if (isset($params['answersValidErrors'][$i]['errors']['votes_number'])): ?><div class="alert alert-danger" role="alert"><?php echo implode('<br/>', $params['answersValidErrors'][$i]['errors']['votes_number']) ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-2 mt-4 pt-2">
                        <button class="btn btn-danger remove_answer">Remove</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="container">
            <div class="row my-3">
                <div class="col-md-2">
                    <button class="btn-secondary btn add_answer">Add answer</button>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-4">
                    <button type="submit" class="btn-primary btn">Save survey</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.remove_answer').click(function (e) {
            e.preventDefault();
            if($('.answer').length > 1) {
                $(this).parents('.answer').remove();
            }
        })
        $('.add_answer').click(function (e) {
            e.preventDefault();
            $('.answers .answer').last().clone(true).appendTo('.answers');
            $('.answers .answer').last().find('input[name="Answer[2][id]"]')
            $('.answers .answer').last().find('input').each(function () {
                let name=$(this).attr('name');
                name=name.replace(/([0-9]+)/g, function (match, i) {
                    return (parseInt(i)+1);
                });
                $(this).attr('name',name);
                if($(this).attr('type')==='hidden') $(this).val(0);
                else $(this).val('');
                $(this).siblings('label').attr('for',name);
                $(this).siblings('.alert').remove();

            });
        })
    </script>
</form>