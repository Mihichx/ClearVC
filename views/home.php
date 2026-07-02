<div class="d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="text-center">
        <!-- Название -->
        <h1 class="display-1 fw-light text-dark mb-4" style="letter-spacing: .15rem;">
            Clear<span class="fw-normal text-danger">VC</span>
        </h1>
        
        <!-- Ссылки для разработчика -->
        <div class="d-flex justify-content-center gap-4 text-uppercase fw-bold text-muted small tracking-widest mb-4">
            <a href="/docs" class="text-decoration-none text-secondary hover-danger">Documentation</a>
            <a href="/routes" class="text-decoration-none text-secondary hover-danger">Route Map</a>
            <a href="https://github.com/Mihichx/ClearVC" target="_blank" class="text-decoration-none text-secondary hover-danger">GitHub</a>
        </div>

        <!-- Информация о системе -->
        <div class="text-muted small font-monospace">
            ClearVC MicroFramework <span class="text-danger"><?= \Core\Controller::VERSION ?></span> (PHP v<?= PHP_VERSION ?>)
        </div>
    </div>
</div>

<style>
    .hover-danger:hover {
        color: #dc3545 !important;
        transition: color 0.2s ease-in-out;
    }
</style>
