<div class="post-details__image-wrapper post-quote">
	<div class="post__main">
	  <blockquote>
          <p>
              <?= clean($post['message']); ?>
          </p>
		<cite><?= (!$post['quote_writer'])? 'Неизвестный Автор' : $post['quote_writer']; ?></cite>
	  </blockquote>
	</div>
</div>
