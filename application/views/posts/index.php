<h2><?= $title ?></h2>
<?php foreach ($posts as $post) : ?>
  <hr>
  <h3><?php echo $post['title'] ?></h3>
  <div class="row">
    <div class="col-md-3">Post</div>
    <div class="col-md-9">
      <small class="post-date">
        Posted on <?php echo $post['created_at'] ?> in
        <span class="badge badge-secondary">
          <?= $post['name'] ?>
        </span>
      </small>

      <p>
        <?= $post['body'] ?>
      </p>

    </div>
  </div>

<?php endforeach ?>