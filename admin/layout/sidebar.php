<div class="d-flex">
  <div class="bg-light border-end" id="sidebar-wrapper" style="min-width: 220px; height: 100vh;">
    <div class="sidebar-heading bg-warning text-dark text-center py-3 fw-bold">
      Admin Dashboard
    </div>
    <div class="list-group list-group-flush">
      <a href="<?= base_url() ?>admin/menu/index.php" class="list-group-item list-group-item-action">
        <i class="bi bi-list"></i> Menu
      </a>
      <a href="<?= base_url() ?>admin/pesanan/index.php" class="list-group-item list-group-item-action">
        <i class="bi bi-basket"></i> Pesanan
      </a>
      <a href="<?= base_url() ?>admin/testimonial/index.php" class="list-group-item list-group-item-action">
        <i class="bi bi-chat-quote"></i> Testimonial
      </a>
      <a href="<?= base_url() ?>admin/contact/index.php" class="list-group-item list-group-item-action">
        <i class="bi bi-geo-alt"></i> Contact
      </a>
      <a href="<?= base_url() ?>admin/users/index.php" class="list-group-item list-group-item-action">
        <i class="bi bi-person"></i> Admin
      </a>
    </div>
  </div>

  <div class="p-4 flex-grow-1">
    <!-- Page content here -->
