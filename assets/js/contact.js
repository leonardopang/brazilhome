// Contact Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initContactForm();
    initFormValidation();
    initPhoneMask();
});

// Contact Form Initialization
function initContactForm() {
    const contactForm = document.getElementById('contactForm');
    const submitButton = document.querySelector('.submit-button');
    
    if (contactForm) {
        contactForm.addEventListener('submit', handleFormSubmit);
    }
    
    // Add input event listeners for real-time validation
    const formInputs = document.querySelectorAll('.form-input, .form-textarea');
    formInputs.forEach(input => {
        input.addEventListener('blur', () => contactValidateField(input));
        input.addEventListener('input', () => contactClearFieldError(input));
    });
    
    // Privacy checkbox validation
    const privacyCheckbox = document.getElementById('privacy');
    if (privacyCheckbox) {
        privacyCheckbox.addEventListener('change', () => validatePrivacyCheckbox());
    }
}

// Handle form submission
async function handleFormSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitButton = form.querySelector('.submit-button');
    const formData = new FormData(form);
    
    // Validate entire form before submission
    if (!validateForm()) {
        showFormMessage('Por favor, corrija os erros antes de enviar.', 'error');
        return;
    }
    
    // Show loading state
    contactSetButtonLoading(submitButton, true);
    
    try {
        // Simulate form submission (replace with actual API call)
        const result = await submitContactForm(formData);
        
        if (result.success) {
            showFormMessage('Mensagem enviada com sucesso! Entraremos em contato em breve.', 'success');
            form.reset();
            clearAllErrors();
        } else {
            showFormMessage('Erro ao enviar mensagem. Tente novamente.', 'error');
        }
    } catch (error) {
        console.error('Form submission error:', error);
        showFormMessage('Erro no servidor. Tente novamente mais tarde.', 'error');
    } finally {
        contactSetButtonLoading(submitButton, false);
    }
}

// Simulate form submission (replace with actual API call)
async function submitContactForm(formData) {
    return new Promise((resolve) => {
        setTimeout(() => {
            // Simulate successful submission
            resolve({ success: true });
        }, 2000);
    });
}

// Form validation
function validateForm() {
    const requiredFields = [
        { id: 'name', type: 'text' },
        { id: 'email', type: 'email' },
        { id: 'phone', type: 'phone' },
        { id: 'message', type: 'text' }
    ];
    
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        if (!contactValidateField(input, field.type)) {
            isValid = false;
        }
    });
    
    // Validate privacy checkbox
    if (!validatePrivacyCheckbox()) {
        isValid = false;
    }
    
    return isValid;
}

// Validate individual field
function contactValidateField(input, type = null) {
    const value = input.value.trim();
    const fieldType = type || input.type;
    
    contactClearFieldError(input);
    
    // Check if field is required and empty
    if (input.hasAttribute('required') && !value) {
        contactShowFieldError(input, 'Este campo é obrigatório.');
        return false;
    }
    
    // Specific validation by field type
    switch (fieldType) {
        case 'email':
            if (value && !isValidEmail(value)) {
                contactShowFieldError(input, 'Por favor, insira um email válido.');
                return false;
            }
            break;
            
        case 'phone':
            if (value && !isValidPhone(value)) {
                contactShowFieldError(input, 'Por favor, insira um telefone válido.');
                return false;
            }
            break;
            
        case 'text':
            if (input.id === 'name' && value && value.length < 2) {
                contactShowFieldError(input, 'Nome deve ter pelo menos 2 caracteres.');
                return false;
            }
            if (input.id === 'message' && value && value.length < 10) {
                contactShowFieldError(input, 'Mensagem deve ter pelo menos 10 caracteres.');
                return false;
            }
            break;
    }
    
    return true;
}

// Validate privacy checkbox
function validatePrivacyCheckbox() {
    const checkbox = document.getElementById('privacy');
    const existingError = document.querySelector('.privacy-error');
    
    if (existingError) {
        existingError.remove();
    }
    
    if (!checkbox.checked) {
        const errorMsg = document.createElement('span');
        errorMsg.className = 'form-error privacy-error';
        errorMsg.textContent = 'Você deve concordar com a Política de Privacidade.';
        checkbox.closest('.privacy-agreement').appendChild(errorMsg);
        return false;
    }
    
    return true;
}

// Email validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Phone validation (Brazilian format)
function isValidPhone(phone) {
    // Remove all non-numeric characters
    const cleanPhone = phone.replace(/\D/g, '');
    // Check if it has 10 or 11 digits (Brazilian phone numbers)
    return cleanPhone.length >= 10 && cleanPhone.length <= 11;
}

// Show field error
function contactShowFieldError(input, message) {
    input.classList.add('error');
    
    // Remove existing error message
    const existingError = input.parentNode.querySelector('.form-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add new error message
    const errorElement = document.createElement('span');
    errorElement.className = 'form-error';
    errorElement.textContent = message;
    input.parentNode.appendChild(errorElement);
}

// Clear field error
function contactClearFieldError(input) {
    input.classList.remove('error');
    const errorElement = input.parentNode.querySelector('.form-error');
    if (errorElement) {
        errorElement.remove();
    }
}

// Clear all form errors
function clearAllErrors() {
    const errorInputs = document.querySelectorAll('.form-input.error, .form-textarea.error');
    const errorMessages = document.querySelectorAll('.form-error');
    
    errorInputs.forEach(input => input.classList.remove('error'));
    errorMessages.forEach(error => error.remove());
}

// Show form message
function showFormMessage(message, type) {
    // Remove existing message
    const existingMessage = document.querySelector('.form-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    // Create new message
    const messageElement = document.createElement('div');
    messageElement.className = `form-message ${type}`;
    messageElement.textContent = message;
    
    // Insert message at the top of the form
    const form = document.getElementById('contactForm');
    form.insertBefore(messageElement, form.firstChild);
    
    // Auto-remove success messages after 5 seconds
    if (type === 'success') {
        setTimeout(() => {
            if (messageElement.parentNode) {
                messageElement.remove();
            }
        }, 5000);
    }
    
    // Scroll to message
    messageElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// Set button loading state
function contactSetButtonLoading(button, isLoading) {
    if (isLoading) {
        button.classList.add('loading');
        button.disabled = true;
        button.textContent = 'ENVIANDO...';
    } else {
        button.classList.remove('loading');
        button.disabled = false;
        button.textContent = 'ENVIAR';
    }
}

// Initialize phone mask
function initPhoneMask() {
    const phoneInput = document.getElementById('phone');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            
            // Apply Brazilian phone mask
            if (value.length <= 10) {
                // (XX) XXXX-XXXX
                value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            } else {
                // (XX) XXXXX-XXXX
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            }
            
            e.target.value = value;
        });
        
        phoneInput.addEventListener('keypress', (e) => {
            // Only allow numbers, backspace, and delete
            const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter'];
            if (allowedKeys.includes(e.key) || /\d/.test(e.key)) {
                return;
            }
            e.preventDefault();
        });
    }
}

// Initialize form validation
function initFormValidation() {
    // Add visual feedback for form interactions
    const formInputs = document.querySelectorAll('.form-input, .form-textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentNode.classList.add('focused');
        });
        
        input.addEventListener('blur', () => {
            if (!input.value.trim()) {
                input.parentNode.classList.remove('focused');
            }
        });
        
        // Keep focus state if input has value
        if (input.value.trim()) {
            input.parentNode.classList.add('focused');
        }
    });
}

// Auto-resize textarea
function initTextareaAutoResize() {
    const textarea = document.getElementById('message');
    
    if (textarea) {
        textarea.addEventListener('input', () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        });
    }
}

// Initialize textarea auto-resize
initTextareaAutoResize();

// Handle form data persistence (optional)
function saveFormData() {
    const formData = {};
    const inputs = document.querySelectorAll('#contactForm input, #contactForm textarea');
    
    inputs.forEach(input => {
        if (input.type !== 'checkbox') {
            formData[input.name] = input.value;
        }
    });
    
    localStorage.setItem('contactFormData', JSON.stringify(formData));
}

function loadFormData() {
    const savedData = localStorage.getItem('contactFormData');
    
    if (savedData) {
        const formData = JSON.parse(savedData);
        
        Object.keys(formData).forEach(key => {
            const input = document.querySelector(`[name="${key}"]`);
            if (input && formData[key]) {
                input.value = formData[key];
                input.parentNode.classList.add('focused');
            }
        });
    }
}

// Save form data on input changes (debounced)
let saveTimeout;
document.addEventListener('input', (e) => {
    if (e.target.closest('#contactForm')) {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(saveFormData, 1000);
    }
});

// Load form data on page load
loadFormData();

// Clear saved data on successful submission
document.addEventListener('formSubmissionSuccess', () => {
    localStorage.removeItem('contactFormData');
});