<?php include 'inc/header.php'; ?>

<?php
// Set vars to empty values
$name = $rating = $url = $email = $body = '';
$nameErr = $ratingErr = $urlErr = $emailErr = $bodyErr = '';

// Form submit
if (isset($_POST['submit'])) {
  // Validate name
  if (empty($_POST['name'])) {
    $nameErr = 'Name is required.';
  } else {
    // $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = filter_input(
      INPUT_POST,
      'name',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  // Validate rating
  if (!empty($_POST['rating']) && !($_POST['rating'] >= 1 && $_POST['rating'] <=5)) {
    $ratingErr = 'Please enter rating values from 1 to 5, or leave empty.';
  } else {
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
  }

  // Validate url
  if (empty($_POST['url'])) {
    $urlErr = 'Video URL is required.';
  } else {
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
  }

  // Validate email
  if (empty($_POST['email'])) {
    $emailErr = 'Email is required.';
  } else {
    // $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }

  // Validate body
  if (empty($_POST['body'])) {
    $bodyErr = 'Feedback is required.';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_input(
      INPUT_POST,
      'body',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  if (empty($nameErr) && empty($emailErr) && empty($bodyErr) && empty($ratingErr) && empty($urlErr) ) {
    // add to database
    $sql = "INSERT INTO feedback (name, email, body, rating, url) VALUES ('$name', '$email', '$body', '$rating', '$url')";
    if (mysqli_query($conn, $sql)) {
      // success
      header('Location: feedback.php');
    } else {
      // error
      echo 'Error: ' . mysqli_error($conn);
    }
  }
}
?>

    <img src="/php-crash/feedback/img/logo.png" class="w-25 mb-3" alt="">
    <h2>Feedback</h2>
    <?php echo isset($name) ? $name : ''; ?>
    <p class="lead text-center">Leave feedback for Traversy Media</p>

    <form method="POST" action="<?php echo htmlspecialchars(
      $_SERVER['PHP_SELF']
    ); ?>" class="mt-4 w-75">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control <?php echo !$nameErr ?:
          'is-invalid'; ?>" id="name" name="name" placeholder="Enter your name" value="<?php echo $name; ?>">
        <div class="invalid-feedback">
          <?php echo $nameErr; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <input type="number" class="form-control <?php echo !$ratingErr ?:
          'is-invalid'; ?>" id="rating" name="rating" min="1" max="5" placeholder="Enter rating" value="<?php echo $rating; ?>">
        <div class="invalid-feedback">
          <?php echo $ratingErr; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="url" class="form-label">Video URL</label>
        <input type="text" class="form-control <?php echo !$urlErr ?:
          'is-invalid'; ?>" id="url" name="url" placeholder="Enter video URL" value="<?php echo $url; ?>">
        <div class="invalid-feedback">
          <?php echo $urlErr; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control <?php echo !$emailErr ?:
          'is-invalid'; ?>" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>">
        <div class="invalid-feedback">
          <?php echo $emailErr; ?>
        </div>  
      </div>
      <div class="mb-3">
        <label for="body" class="form-label">Feedback</label>
        <textarea class="form-control <?php echo !$bodyErr ?:
          'is-invalid'; ?>" id="body" name="body" placeholder="Enter your feedback"><?php echo $body; ?></textarea>
        <div class="invalid-feedback">
          <?php echo $bodyErr; ?>
        </div>  
      </div>
      <div class="mb-3">
        <input type="submit" name="submit" value="Send" class="btn btn-dark w-100">
      </div>
    </form>
<?php include 'inc/footer.php'; ?>
