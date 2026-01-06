// Espera a que todo el contenido del DOM esté cargado para ejecutar el script
document.addEventListener('DOMContentLoaded', () => {

    // 1. ESTRUCTURA DE DATOS
    // Se utiliza un array de objetos para evitar la sobreescritura de datos
    const questions = [
        { answer: '1/0 AWG', question: 'Calibre del conductor de neutro si, el conductor de fase es 4/0, segun la norma EMCALI' },
        { answer: '4 AWG', question: 'Calibre del conductor de neutro si, el conductor de fase es 1/0, segun la norma EMCALI' },
        { answer: '4 AWG', question: 'Calibre del conductor de neutro si, el conductor de fase es 4, segun la norma EMCALI' },
        { answer: '2 AWG', question: 'El conductor <b>sparrow (33.62 mm²)</b>' },
        { answer: '2/0 AWG', question: 'El conductor <b>quail (67.44 mm²)</b>' },
        { answer: '1/0 AWG', question: 'El conductor <b>raven (53.50 mm²)</b>' },
        { answer: '4/0 AWG', question: 'El conductor <b>Penguin (107.21 mm²)</b>' },
        { answer: '266.8 AWG', question: 'El conductor <b>Waxwing (135.2 mm²)</b>' },
        { answer: '350 AWG', question: 'El conductor <b>177.34 mm²</b>' },
        { answer: '397.5 AWG', question: 'El conductor <b>Chickadee (201.4 mm²)</b>' },
        { answer: '477 AWG', question: 'El conductor <b>Pelican (241.7 mm²)</b>' },
        { answer: '500 AWG', question: 'El conductor <b>253.7 mm²</b>' },
        { answer: '2 AWG', question: 'Conductor ACSR semi aislada, para cargas máxima de 184 A' },
        { answer: '1/0 AWG', question: 'Conductor ACSR semi aislada, para cargas maxima de 241 A' },
        { answer: '4/0 AWG', question: 'Conductor ACSR semi aislada, para cargas maxima de 355 A' },
        { answer: '266.5 AWG', question: 'Conductor ACSR semi aislada para cargas maxima de 458 A' },
        { answer: '336.8 AWG', question: 'Conductor ACSR semi aislada, para cargas maxima de 530 A' },
        { answer: '2 AWG', question: 'Conductor subterraneo (Al) para carga maxima de 120 A' },
        { answer: '1/0 AWG', question: 'Conductor subterraneo (Al) para carga maxima de 155 A' },
        { answer: '4/0 AWG', question: 'Conductor subterraneo (Al) para carga maxima de 230 A' },
        { answer: '250 AWG', question: 'Conductor subterraneo (Al) para carga maxima de 250 A' },
        { answer: '350 AWG', question: 'Conductor subterraneo (Al) para carga maxima de 305 A' },
        { answer: '500 AWG', question: 'Conductor subterraneo (Al) para carga maxima de 370 A' },
        { answer: '2 AWG', question: 'Conductor subterraneo (CU) para carga maxima de 155 A' },
        { answer: '1/0 AWG', question: 'Conductor subterraneo (CU) para carga maxima de 200 A' },
        { answer: '4/0 AWG', question: 'Conductor subterraneo (CU) para carga maxima de 295 A' },
        { answer: '250 AWG', question: 'Conductor subterraneo (CU) para carga maxima de 325 A' },
        { answer: '350 AWG', question: 'Conductor subterraneo (CU) para carga maxima de 390 A' },
        { answer: '500 AWG', question: 'Conductor subterraneo (CU) para carga maxima de 465 A' }
    ];

    // 2. SELECCIÓN DE ELEMENTOS DEL DOM
    const questionTextElement = document.getElementById('question-text');
    const optionsForm = document.getElementById('options-form');
    const feedbackElement = document.getElementById('feedback');
    const submitButton = document.getElementById('submit-btn');
    const newQuestionButton = document.getElementById('new-question-btn');
    
    let correctAnswer = '';
    let isAnswered = false;

    // 3. FUNCIONES PRINCIPALES
    function generateQuestion() {
        // Limpiar estado anterior
        feedbackElement.innerHTML = '';
        optionsForm.innerHTML = '';
        isAnswered = false;
        submitButton.disabled = false;

        // Seleccionar una pregunta al azar
        const randomIndex = Math.floor(Math.random() * questions.length);
        const currentQuestion = questions[randomIndex];
        
        questionTextElement.innerHTML = `<i>${currentQuestion.question}:</i>`;
        correctAnswer = currentQuestion.answer;

        // Generar 4 opciones únicas (1 correcta, 3 incorrectas)
        const options = new Set([correctAnswer]);
        while (options.size < 4) {
            const randomOptionIndex = Math.floor(Math.random() * questions.length);
            options.add(questions[randomOptionIndex].answer);
        }

        // Mezclar opciones y renderizarlas en el HTML
        const shuffledOptions = Array.from(options).sort(() => Math.random() - 0.5);

        shuffledOptions.forEach((option, index) => {
            const optionId = `option_${index}`;
            const div = document.createElement('div');
            div.className = 'form-check mb-3';
            div.innerHTML = `
                <input class="form-check-input" type="radio" name="option" id="${optionId}" value="${option}">
                <label class="form-check-label" for="${optionId}">${option}</label>
            `;
            optionsForm.appendChild(div);
        });
    }

    function checkAnswer() {
        if (isAnswered) return; // Evitar calificar múltiples veces

        const selectedOption = optionsForm.querySelector('input[name="option"]:checked');

        if (!selectedOption) {
            feedbackElement.innerHTML = `<div class="alert alert-warning">Por favor, selecciona una respuesta.</div>`;
            return;
        }
        
        isAnswered = true;
        submitButton.disabled = true;

        if (selectedOption.value === correctAnswer) {
            feedbackElement.innerHTML = `<div class="alert alert-success"><strong>¡Correcto!</strong></div>`;
        } else {
            feedbackElement.innerHTML = `<div class="alert alert-danger"><strong>Incorrecto.</strong> La respuesta correcta era <strong>${correctAnswer}</strong>.</div>`;
        }
    }

    // 4. ASIGNACIÓN DE EVENTOS
    submitButton.addEventListener('click', checkAnswer);
    newQuestionButton.addEventListener('click', generateQuestion);

    // 5. INICIALIZACIÓN
    // Cargar la primera pregunta al iniciar la página
    generateQuestion();
});
