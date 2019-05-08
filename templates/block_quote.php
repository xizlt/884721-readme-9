<div class="post-details__image-wrapper post-quote">
	<div class="post__main">
	  <blockquote>
          <p>
              <?= clips_text(clean($post['message'])); ?>
          </p>
		<cite><?= (!$post['quote_writer'])? 'Неизвестный Автор' : $post['quote_writer']; ?></cite>
	  </blockquote>
	</div>
</div>
