<div class="theme-switch">
    <input type="checkbox" id="theme-toggle" class="theme-toggle">
    <label for="theme-toggle" class="theme-label">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </label>
</div>

<style>
.theme-switch {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.theme-toggle {
    display: none;
}

.theme-label {
    cursor: pointer;
    padding: 10px;
    background-color: var(--card-bg);
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
}

.theme-label i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.theme-toggle:checked ~ .theme-label .bx-sun,
.theme-toggle:not(:checked) ~ .theme-label .bx-moon {
    display: none;
}
</style> 