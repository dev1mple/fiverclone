<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

// Check if user is a freelancer or administrator (administrators can act as freelancers)
// isAdmin() returns false for freelancers (is_client = 0), true for clients (is_client = 1)
if ($userObj->isAdmin() && !$userObj->isFiverrAdministrator()) {
  header("Location: ../client/index.php");
  exit;
} 
?>
<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
      body {
        font-family: "Arial";
      }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
      <div class="display-4 text-center">Hello there and welcome! 
        <span class="text-success"><?php echo $_SESSION['username']; ?>
          <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'fiverr_administrator'): ?>
            <span class="badge badge-warning ml-2">ADMIN</span>
          <?php endif; ?>
        </span>. 
        Add Proposal Here!
      </div>
      <div class="row">
        <div class="col-md-5">
          <div class="card mt-4 mb-4">
            <div class="card-body">
              <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <?php  
                  if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

                    if ($_SESSION['status'] == "200") {
                      echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
                    }

                    else {
                      echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>"; 
                    }

                  }
                  unset($_SESSION['message']);
                  unset($_SESSION['status']);
                  ?>
                  <h1 class="mb-4 mt-4">Add Proposal Here!</h1>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <input type="text" class="form-control" name="description" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Minimum Price</label>
                    <input type="number" class="form-control" name="min_price" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Max Price</label>
                    <input type="number" class="form-control" name="max_price" required>
                  </div>
                  <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" name="category_id" id="category_id" onchange="loadSubcategories()">
                      <option value="">Select a category</option>
                      <?php 
                      $categories = $categoryObj->getCategories();
                      foreach ($categories as $category): 
                      ?>
                        <option value="<?php echo $category['category_id']; ?>">
                          <?php echo htmlspecialchars($category['category_name']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="subcategory_id">Subcategory</label>
                    <select class="form-control" name="subcategory_id" id="subcategory_id">
                      <option value="">Select a subcategory</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Image</label>
                    <input type="file" class="form-control" name="image" required>
                    <input type="submit" class="btn btn-primary float-right mt-4" name="insertNewProposalBtn">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <?php $getProposals = $proposalObj->getProposals(); ?>
          <?php foreach ($getProposals as $proposal) { ?>
          <div class="card shadow mt-4 mb-4">
            <div class="card-body">
              <h2><a href="other_profile_view.php?user_id=<?php echo $proposal['user_id']; ?>"><?php echo $proposal['username']; ?>
                <?php if (isset($proposal['user_role']) && $proposal['user_role'] === 'fiverr_administrator'): ?>
                  <span class="badge badge-warning ml-1">ADMIN</span>
                <?php endif; ?>
              </a></h2>
              <img src="<?php echo '../images/' . $proposal['image']; ?>" alt="">
              <p class="mt-4"><i><?php echo $proposal['proposals_date_added']; ?></i></p>
              <p class="mt-2"><?php echo $proposal['description']; ?></p>
              <?php if (!empty($proposal['category_name'])): ?>
                <p class="mt-2"><strong>Category:</strong> <?php echo htmlspecialchars($proposal['category_name']); ?>
                <?php if (!empty($proposal['subcategory_name'])): ?>
                  > <?php echo htmlspecialchars($proposal['subcategory_name']); ?>
                <?php endif; ?>
                </p>
              <?php endif; ?>
              <h4><i><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']); ?> PHP</i></h4>
              <div class="float-right">
                <a href="#">Check out services</a>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    
    <script>
    function loadSubcategories() {
        const categoryId = document.getElementById('category_id').value;
        const subcategorySelect = document.getElementById('subcategory_id');
        
        // Clear existing options
        subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
        
        if (categoryId) {
            // Make AJAX request to get subcategories
            fetch('get_subcategories.php?category_id=' + categoryId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.subcategory_id;
                        option.textContent = subcategory.subcategory_name;
                        subcategorySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading subcategories:', error);
                });
        }
    }
    </script>
  </body>
</html>