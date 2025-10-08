<?php
session_start();
include('../header/header.php');
?>
<section class="vh-100 d-flex align-items-center justify-content-center"
    style="background: linear-gradient(135deg, #36d1dc, #5b86e5);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">

                        <h3 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-person-plus me-2"></i>Vendor Registration
                        </h3>

                        <form method="post" action="vendor_register_process.php" id="registerForm">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Enter your email" required>
                                    <button type="button" class="btn btn-outline-primary" id="sendOtpBtn">Verify
                                        Email</button>
                                </div>
                                <small id="otpStatus" class="text-success"></small>

                                <div id="otpSection" class="mt-3" style="display:none;">
                                    <input type="text" id="otp" class="form-control mb-2" placeholder="Enter OTP">
                                    <button type="button" class="btn btn-success w-100" id="verifyOtpBtn">Submit
                                        OTP</button>
                                    <div id="verifyStatus" class="mt-2 fw-semibold text-center"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Company Name</label>
                                <input type="text" name="company_name" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2 mt-2">Register</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const verifyOtpBtn = document.getElementById('verifyOtpBtn');

    // --- SEND OTP ---
    if (sendOtpBtn) {
        sendOtpBtn.addEventListener('click', function () {
            const email = document.getElementById('email').value.trim();
            const otpStatus = document.getElementById('otpStatus');
            otpStatus.innerHTML = '<span style="color:blue;">Sending OTP...</span>';

            if (!email) {
                otpStatus.innerHTML = '<span style="color:red;">Please enter your email first</span>';
                return;
            }

            fetch('send_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'email=' + encodeURIComponent(email)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    otpStatus.innerHTML = `<span style="color:green;">✅ ${data.message}</span>`;
                    document.getElementById('otpSection').style.display = 'block';
                } else {
                    otpStatus.innerHTML = `<span style="color:red;">❌ ${data.error}</span>`;
                }
            })
            .catch(() => {
                otpStatus.innerHTML = '<span style="color:red;">⚠️ Failed to send OTP.</span>';
            });
        });
    }

    // --- VERIFY OTP ---
    if (verifyOtpBtn) {
        verifyOtpBtn.addEventListener('click', function () {
            const otp = document.getElementById('otp').value.trim();
            const msg = document.getElementById('verifyStatus');
            msg.innerHTML = '<span style="color:blue;">Verifying OTP...</span>';

            if (!otp) {
                msg.innerHTML = '<span style="color:red;">Please enter OTP</span>';
                return;
            }

            fetch('verify_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'otp=' + encodeURIComponent(otp)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    msg.innerHTML = `<span style="color:green;">✅ ${data.message}</span>`;
                    document.getElementById('otp').disabled = true;
                    verifyOtpBtn.disabled = true;
                    sendOtpBtn.disabled = true;
                } else {
                    msg.innerHTML = `<span style="color:red;">❌ ${data.error}</span>`;
                }
            })
            .catch(() => {
                msg.innerHTML = '<span style="color:red;">⚠️ Server error. Please try again.</span>';
            });
        });
    }
});
</script>




<?php include('../footer/footer.php'); ?>