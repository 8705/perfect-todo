<?php $this->setLayoutVar('title', 'アカウント') ?>

<div class="container">
    <div class="row">
    <div class="col-md-3 projects">
        <h2>プロジェクトリスト</h2>
        <ul class="list-group">
            <?php foreach ($projects as $project): ?>
            <li class="project list-group-item">
                <p><?php echo $this->escape($project['p_title']); ?><span><a href="/project/delete/<?php echo $this->escape($project['id']); ?>">x</a></span></p>
                <p class="content"><?php echo $this->escape($project['p_content']); ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
        <h2>プロジェクト追加</h2>
        <form action="project/add" method="POST">
            <p>
                <input type="text" name="p_title">
            </p>
            <textarea name="p_content" id="" cols="30" rows="3"></textarea>
            <input type="submit" value="submit">
        </form>
        <h2>タスク追加</h2>
        <form action="task/add" method="POST">
            <p>
                <select name="p_id" id="">
                    <option value="">プロジェクトを選択</option>
                    <?php foreach($projects as $project): ?>
                    <option value="<?php echo $this->escape($project['id']) ?>"><?php echo $this->escape($project['p_title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p><input type="text" name="t_title"></p>
            <textarea name="t_content" id="" cols="30" rows="3"></textarea>
            <p>
                <select name="t_size" id="">
                    <option value="short">short</option>
                    <option value="middle">middle</option>
                </select>
            </p>
            <input type="submit" value="タスクGO!">
        </form>
    </div>
    <div class="col-md-9 tasks">
        <h2>タスクリスト</h2>
        <ul class="list-group">
            <?php foreach ($tasks as $task): ?>
            <li class="task list-group-item">
                <p><span class="label label-<?php echo $this->escape($task['t_size']); ?>"><?php echo $this->escape($task['t_size']); ?></span><?php echo $this->escape($task['t_title']); ?>(<?php echo $this->escape($task['p_title']); ?>)</p>
                <p class="content"><?php echo $this->escape($task['t_content']); ?><span>[ <?php echo $this->escape($task['created']); ?>に<?php echo $this->escape($task['username']) ?>が作成 ]</span><span><a href="/task/delete/<?php echo $this->escape($task['id']); ?>">x</a></span></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    </div>
</div>