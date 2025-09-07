<?php include 'header.php'; ?>

<div class="container" style="text-align:center; padding:50px;">
    <h2>✅ Thank You!</h2>
    <p>Your appointment has been booked successfully.</p>
    <p>You will now be redirected to the Feedback page...</p>
</div>

<script>
    // 5 seconds baad feedback page pe bhej dega
    setTimeout(function() {
        window.location.href = "Feedback.php";
    }, 5000);
</script>

<?php include 'footer.php'; ?>
