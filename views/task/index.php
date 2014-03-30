<?php $this->setLayoutVar('title', 'アカウント') ?>

<div class="container">
    <div class="row">
    <div class="col-md-3 projects">
        <h2>プロジェクトリスト</h2>
        <ul class="list-group">
            <?php foreach ($projects as $project): ?>
            <li class="project list-group-item">
                <p><?php echo $this->escape($project['p_title']); ?></p>
                <p class="content"><?php echo $this->escape($project['p_content']); ?></p>
            </li>
            <?php endforeach; ?>
        </ul>

    </div>
    <div class="col-md-9 tasks">
        <h2>タスクリスト</h2>
        <ul class="list-group">
            <?php foreach ($tasks as $task): ?>
            <li class="task list-group-item">
                <p><span class="label label-<?php echo $this->escape($task['t_size']); ?>"><?php echo $this->escape($task['t_size']); ?></span><?php echo $this->escape($task['t_title']); ?>(<?php echo $this->escape($task['p_title']); ?>)</p>
                <p class="content"><?php echo $this->escape($task['t_content']); ?><span>[ <?php echo $this->escape($task['created']); ?>に<?php echo $this->escape($task['username']) ?>が作成 ]</span></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    </div>
</div>