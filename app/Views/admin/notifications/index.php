<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $showSidebar = true; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-bell me-2"></i>Notification Settings
    </h1>
</div>

<div class="row">
    <!-- Email Configuration -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-envelope me-2"></i>Email Configuration (Brevo)
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>API Key Status:</strong></label>
                    <span class="badge <?= !empty($_ENV['BREVO_API_KEY']) ? 'bg-success' : 'bg-danger' ?>">
                        <?= !empty($_ENV['BREVO_API_KEY']) ? 'Configured' : 'Not Configured' ?>
                    </span>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Sender Email:</strong></label>
                    <p class="text-muted"><?= $_ENV['BREVO_SENDER_EMAIL'] ?? 'noreply@smartelite.tz' ?></p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Reply To:</strong></label>
                    <p class="text-muted"><?= $_ENV['BREVO_REPLY_TO'] ?? 'support@smartelite.tz' ?></p>
                </div>

                <div class="d-grid">
                    <form method="post" action="<?= base_url('admin/notifications/test-email') ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary" <?= empty($_ENV['BREVO_API_KEY']) ? 'disabled' : '' ?>>
                            <i class="bi bi-send me-2"></i>Send Test Email
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SMS Configuration -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-phone me-2"></i>SMS Configuration (Textify)
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>API Key Status:</strong></label>
                    <span class="badge <?= !empty($_ENV['TEXTIFY_API_KEY']) ? 'bg-success' : 'bg-danger' ?>">
                        <?= !empty($_ENV['TEXTIFY_API_KEY']) ? 'Configured' : 'Not Configured' ?>
                    </span>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Sender ID:</strong></label>
                    <p class="text-muted"><?= $_ENV['TEXTIFY_SENDER_ID'] ?? 'SmartElite' ?></p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>API URL:</strong></label>
                    <p class="text-muted">https://api.textify.africa/v1</p>
                </div>

                <div class="d-grid">
                    <form method="post" action="<?= base_url('admin/notifications/test-sms') ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-success" <?= empty($_ENV['TEXTIFY_API_KEY']) ? 'disabled' : '' ?>>
                            <i class="bi bi-send me-2"></i>Send Test SMS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Test Notification -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="bi bi-gear me-2"></i>Custom Test Notification
                </h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('admin/notifications/send-test') ?>">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Test Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="test@example.com" value="<?= $_ENV['ADMIN_NOTIFICATION_EMAIL'] ?? '' ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Test Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   placeholder="+255123456789" value="<?= $_ENV['ADMIN_NOTIFICATION_SMS'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Test Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" 
                                  placeholder="Enter your test message here...">This is a test notification from SmartElite Initiative. Your notification system is working correctly!</textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-send me-2"></i>Send Test Notification
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Configuration Instructions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Configuration Instructions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-envelope me-2"></i>Brevo Email Setup:</h6>
                        <ol>
                            <li>Create a free account at <a href="https://www.brevo.com" target="_blank">brevo.com</a></li>
                            <li>Go to SMTP & API settings</li>
                            <li>Generate a new API key</li>
                            <li>Add the following to your <code>.env</code> file:</li>
                        </ol>
                        <pre class="bg-light p-3 rounded"><code>BREVO_API_KEY=your_api_key_here
BREVO_SENDER_EMAIL=noreply@yourdomain.com
BREVO_REPLY_TO=support@yourdomain.com</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-phone me-2"></i>Textify SMS Setup:</h6>
                        <ol>
                            <li>Create an account at <a href="https://textify.africa" target="_blank">textify.africa</a></li>
                            <li>Get your API key from the dashboard</li>
                            <li>Add the following to your <code>.env</code> file:</li>
                        </ol>
                        <pre class="bg-light p-3 rounded"><code>TEXTIFY_API_KEY=your_api_key_here
TEXTIFY_SENDER_ID=SmartElite</code></pre>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Important:</strong> After adding the environment variables, restart your web server for the changes to take effect.
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
