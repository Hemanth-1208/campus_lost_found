<?php
$pageTitle = 'Find what matters';
require 'includes/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <span class="eyebrow">A smarter campus community</span>
    <h1>Lost something?<br><span>Let's bring it back.</span></h1>
    <p>One simple place for students to report lost belongings, share found items and safely reconnect people with what matters.</p>
    <div class="hero-actions">
      <a class="btn" href="register.php">Join CampusFind <span>→</span></a>
      <a class="btn btn-light" href="login.php">Sign in</a>
    </div>
    <div class="trust-line"><span class="dot"></span> Built for your campus community</div>
  </div>
  <div class="hero-visual">
    <div class="visual-card visual-main">
      <div class="visual-top"><span class="status-pill">● Recently found</span><span>•••</span></div>
      <div class="item-emoji">🎧</div>
      <h3>Wireless headphones</h3><p>Library · Block A</p>
      <div class="visual-bottom"><span>Found today</span><strong>View item ↗</strong></div>
    </div>
    <div class="floating-note"><span class="note-icon">✓</span><div><strong>Reunited!</strong><small>Another happy campus story</small></div></div>
    <div class="orb orb-one"></div><div class="orb orb-two"></div>
  </div>
</section>
<section class="section">
  <div class="section-heading"><span class="eyebrow">HOW IT WORKS</span><h2>From lost to found in a few steps.</h2><p>A simple process designed to make campus life easier.</p></div>
  <div class="feature-grid">
    <article class="feature-card"><div class="feature-icon lavender">＋</div><h3>Report an item</h3><p>Share the item name, description, location and a photo.</p></article>
    <article class="feature-card"><div class="feature-icon mint">⌕</div><h3>Search the campus</h3><p>Browse listings and filter by category or item status.</p></article>
    <article class="feature-card"><div class="feature-icon peach">♡</div><h3>Claim it safely</h3><p>Send a claim request and let the admin verify ownership.</p></article>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
