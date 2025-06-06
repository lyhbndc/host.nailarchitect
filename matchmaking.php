<?php
// Start session
session_start();

// Check if user is logged in
$logged_in = isset($_SESSION['user_id']);

// If logged in, get the first letter of the user's first name for the avatar
if ($logged_in) {
    $first_letter = substr($_SESSION['user_name'], 0, 1);
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="bg-gradient.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="Assets/favicon.png">
    <title>Nail Architect - Matchmaking Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f2e9e9;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
        }

        .container {
            max-width: 1500px;
            width: 100%;
            flex: 1;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            
        }

        .quiz-card {
            background-color: rgb(245, 207, 207);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            border: 1px solid rgba(235, 184, 184, 0.3);
  box-shadow: 
    0 4px 16px rgba(0, 0, 0, 0.1),
    0 2px 8px rgba(0, 0, 0, 0.05),
    inset 0 1px 2px rgba(255, 255, 255, 0.3);
        }

        .quiz-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .question-card {
            display: none;
        }

        .question-card.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        .option-card {
            background-color: #F2E9E9;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .option-card:hover {
            background-color: #D9BBB0;
            transform: translateY(-3px);
        }

        .option-card.selected {
            background-color: #D9BBB0;
        }

        .option-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin-right: 15px;
            object-fit: cover;
        }

        .progress-container {
            margin: 20px 0;
        }

        .progress {
            height: 10px;
            border-radius: 10px;
        }

        .progress-bar {
            background-color: #e0c5b7;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-nav {
            padding: 8px 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #D9BBB0;
            border-color: #c78c8c;
        }

        .btn-primary:hover {
            background-color: #b77b7b;
            border-color: #b77b7b;
            transform: translateY(-2px);
        }

        .results-card {
            text-align: center;
            display: none;
        }

        .result-image {
            width: 200px;
            height: 200px;
            border-radius: 15px;
            margin: 20px auto;
            object-fit: cover;
        }

        .book-now-btn {
            margin-top: 20px;
            padding: 10px 30px;
            font-size: 18px;
            border-radius: 20px;
            background: linear-gradient(to right, #e6a4a4, #d98d8d);
        }
        .book-now-btn:hover{
            background: linear-gradient(to right, #d98d8d, #ce7878);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="gradient-overlay"></div>
    <div class="background-pattern"></div>
    <div class="swirl-pattern"></div>
    <div class="polish-drips"></div>
    <div class="container">
        <header>
            <div class="logo-container">
                <div class="logo">
                    <a href="index.php">
                        <img src="Assets/logo.png" alt="Nail Architect Logo">
                    </a>
                </div>
            </div>
            <div class="nav-links">
                <div class="nav-link">Services</div>
                <div class="book-now">Book Now</div>
                <?php if ($logged_in): ?>
                    <div class="user-initial"><?php echo $first_letter; ?></div>
                <?php else: ?>
                    <div class="login-icon"><i class="fa fa-user"></i></div>
                <?php endif; ?>
            </div>
        </header>

        <div class="container py-5">
            <div class="quiz-container">
                <div class="quiz-card">
                    <div class="quiz-header">
                        <h1>Find Your Perfect Nail Style</h1>
                        <p class="lead">Answer a few questions to discover which nail style would suit you best!</p>
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress-container">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="text-end mt-2"><span id="current-question">1</span> of <span id="total-questions">5</span></p>
                    </div>

                    <!-- Question 1 -->
                    <div class="question-card active" data-question="1">
                        <h3>How would you describe your everyday lifestyle?</h3>
                        <div class="options-container">
                            <div class="option-card" data-value="practical">
                                <img src="Assets/active.jpg" alt="Active" class="option-image">
                                <div>
                                    <h5>Active & Hands-on</h5>
                                    <p>I'm always busy, working with my hands, or doing sports.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="balanced">
                                <img src="Assets/balanced.jpg" alt="Balanced" class="option-image">
                                <div>
                                    <h5>Balanced</h5>
                                    <p>I have a mix of active and relaxed days.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="gentle">
                                <img src="Assets/gentle.jpg" alt="Gentle" class="option-image">
                                <div>
                                    <h5>Gentle & Careful</h5>
                                    <p>I can easily maintain delicate styles without damage.</p>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-buttons">
                            <button class="btn btn-outline-secondary btn-nav invisible">Previous</button>
                            <button class="btn btn-primary btn-nav btn-next" disabled>Next</button>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="question-card" data-question="2">
                        <h3>How much time are you willing to spend on nail maintenance?</h3>
                        <div class="options-container">
                            <div class="option-card" data-value="minimal">
                                <img src="Assets/minimal.jpg" alt="Minimal" class="option-image">
                                <div>
                                    <h5>Minimal</h5>
                                    <p>I want something that requires almost no upkeep.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="moderate">
                                <img src="Assets/moderate.jpg" alt="Moderate" class="option-image">
                                <div>
                                    <h5>Moderate</h5>
                                    <p>I can do some maintenance but nothing too demanding.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="dedicated">
                                <img src="Assets/dedicated.jpg" alt="High" class="option-image">
                                <div>
                                    <h5>Dedicated</h5>
                                    <p>I'm happy to invest time to keep my nails looking perfect.</p>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-buttons">
                            <button class="btn btn-outline-secondary btn-nav btn-prev">Previous</button>
                            <button class="btn btn-primary btn-nav btn-next" disabled>Next</button>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="question-card" data-question="3">
                        <h3>What's your preferred nail length?</h3>
                        <div class="options-container">
                            <div class="option-card" data-value="short">
                                <img src="Assets/short.jpg" alt="Short" class="option-image">
                                <div>
                                    <h5>Short</h5>
                                    <p>Practical and close to the fingertip.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="medium">
                                <img src="Assets/medium.jpg" alt="Medium" class="option-image">
                                <div>
                                    <h5>Medium</h5>
                                    <p>Just past the fingertip, elegant but manageable.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="long">
                                <img src="Assets/long.jpg" alt="Long" class="option-image">
                                <div>
                                    <h5>Long</h5>
                                    <p>Dramatic and statement-making extensions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-buttons">
                            <button class="btn btn-outline-secondary btn-nav btn-prev">Previous</button>
                            <button class="btn btn-primary btn-nav btn-next" disabled>Next</button>
                        </div>
                    </div>

                    <!-- Question 4 -->
                    <div class="question-card" data-question="4">
                        <h3>What's your style personality?</h3>
                        <div class="options-container">
                            <div class="option-card" data-value="classic">
                                <img src="Assets/classic.jpg" alt="Classic" class="option-image">
                                <div>
                                    <h5>Classic & Elegant</h5>
                                    <p>I prefer timeless, sophisticated looks.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="trendy">
                                <img src="Assets/trendy.jpg" alt="Trendy" class="option-image">
                                <div>
                                    <h5>Trendy & Bold</h5>
                                    <p>I love experimenting with the latest styles.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="artistic">
                                <img src="Assets/artistic.jpg" alt="Artistic" class="option-image">
                                <div>
                                    <h5>Artistic & Unique</h5>
                                    <p>I want my nails to be an expression of creativity.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="natural">
                                <img src="Assets/natural.jpg" alt="Natural" class="option-image">
                                <div>
                                    <h5>Natural & Subtle</h5>
                                    <p>I prefer a polished but understated look.</p>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-buttons">
                            <button class="btn btn-outline-secondary btn-nav btn-prev">Previous</button>
                            <button class="btn btn-primary btn-nav btn-next" disabled>Next</button>
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div class="question-card" data-question="5">
                        <h3>How often do you want to change your nail style?</h3>
                        <div class="options-container">
                            <div class="option-card" data-value="frequent">
                                <img src="Assets/chrome.jpg" alt="Frequent" class="option-image">
                                <div>
                                    <h5>Frequently</h5>
                                    <p>I like to change my look every 1-2 weeks.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="regular">
                                <img src="Assets/chrome.jpg" alt="Regular" class="option-image">
                                <div>
                                    <h5>Regularly</h5>
                                    <p>Every 3-4 weeks is perfect for me.</p>
                                </div>
                            </div>
                            <div class="option-card" data-value="occasionally">
                                <img src="Assets/chrome.jpg" alt="Occasional" class="option-image">
                                <div>
                                    <h5>Occasionally</h5>
                                    <p>I prefer something that lasts 6+ weeks.</p>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-buttons">
                            <button class="btn btn-outline-secondary btn-nav btn-prev">Previous</button>
                            <button class="btn btn-primary btn-nav btn-submit" disabled>See Results</button>
                        </div>
                    </div>

                    <!-- Results Section -->
                    <div class="results-card">
                        <h2>Your Perfect Nail Style Match</h2>
                        <div id="result-content">
                            <!-- Results will be populated by JavaScript -->
                        </div>
                        <div id="other-matches" class="mt-4">
                            <h4>You Might Also Like</h4>
                            <div class="row" id="other-matches-content">
                                <!-- Other matches will be populated by JavaScript -->
                            </div>
                        </div>
                        <a href="booking.php" class="btn btn-primary book-now-btn">Book This Style Now</a>
                        <div class="mt-3">
                            <button class="btn btn-outline-secondary" id="retake-quiz">Retake Quiz</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all quiz elements
            const questions = document.querySelectorAll('.question-card');
            const totalQuestions = questions.length;
            document.getElementById('total-questions').textContent = totalQuestions;

            const progressBar = document.querySelector('.progress-bar');
            const resultsCard = document.querySelector('.results-card');

            // Store answers
            let answers = {};

            // Handle option selection
            const optionCards = document.querySelectorAll('.option-card');
            optionCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Deselect other options in the same question
                    const parentQuestion = this.closest('.question-card');
                    const options = parentQuestion.querySelectorAll('.option-card');
                    options.forEach(option => option.classList.remove('selected'));

                    // Select this option
                    this.classList.add('selected');

                    // Enable next/submit button
                    const nextBtn = parentQuestion.querySelector('.btn-next, .btn-submit');
                    if (nextBtn) nextBtn.disabled = false;

                    // Store answer
                    const questionNum = parentQuestion.dataset.question;
                    const answer = this.dataset.value;
                    answers[questionNum] = answer;
                });
            });

            // Handle navigation - next button
            const nextButtons = document.querySelectorAll('.btn-next');
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentQuestion = this.closest('.question-card');
                    const currentNum = parseInt(currentQuestion.dataset.question);
                    const nextNum = currentNum + 1;

                    // Hide current question
                    currentQuestion.classList.remove('active');

                    // Show next question
                    const nextQuestion = document.querySelector(`.question-card[data-question="${nextNum}"]`);
                    if (nextQuestion) {
                        nextQuestion.classList.add('active');
                        document.getElementById('current-question').textContent = nextNum;

                        // Update progress bar
                        const progress = (nextNum / totalQuestions) * 100;
                        progressBar.style.width = `${progress}%`;
                        progressBar.setAttribute('aria-valuenow', progress);
                    }

                    // Scroll to top of question
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });

            // Handle navigation - previous button
            const prevButtons = document.querySelectorAll('.btn-prev');
            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentQuestion = this.closest('.question-card');
                    const currentNum = parseInt(currentQuestion.dataset.question);
                    const prevNum = currentNum - 1;

                    // Hide current question
                    currentQuestion.classList.remove('active');

                    // Show previous question
                    const prevQuestion = document.querySelector(`.question-card[data-question="${prevNum}"]`);
                    if (prevQuestion) {
                        prevQuestion.classList.add('active');
                        document.getElementById('current-question').textContent = prevNum;

                        // Update progress bar
                        const progress = (prevNum / totalQuestions) * 100;
                        progressBar.style.width = `${progress}%`;
                        progressBar.setAttribute('aria-valuenow', progress);
                    }

                    // Scroll to top of question
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });

            // Handle submit button
            const submitButton = document.querySelector('.btn-submit');
            submitButton.addEventListener('click', function() {
                // Hide all questions
                questions.forEach(question => {
                    question.classList.remove('active');
                });

                // Show results
                showResults(answers);
                resultsCard.style.display = 'block';

                // Update progress bar to 100%
                progressBar.style.width = '100%';
                progressBar.setAttribute('aria-valuenow', 100);

                // Hide progress container
                document.querySelector('.progress-container').style.display = 'none';
            });

            // Handle retake quiz button
            document.getElementById('retake-quiz').addEventListener('click', function() {
                // Reset the quiz
                resultsCard.style.display = 'none';
                document.querySelector('.progress-container').style.display = 'block';

                // Show first question
                questions.forEach(question => {
                    question.classList.remove('active');
                });
                questions[0].classList.add('active');

                // Reset progress bar
                progressBar.style.width = '0%';
                progressBar.setAttribute('aria-valuenow', 0);
                document.getElementById('current-question').textContent = '1';

                // Reset selections
                optionCards.forEach(card => {
                    card.classList.remove('selected');
                });

                // Reset buttons
                const navButtons = document.querySelectorAll('.btn-next, .btn-submit');
                navButtons.forEach(button => {
                    button.disabled = true;
                });

                // Clear answers
                answers = {};
            });

            // Function to determine and show results
            function showResults(answers) {
                console.log('Answers:', answers);

                // Get best match
                let bestMatch = determineMatch(answers);
                let otherMatches = determineOtherMatches(bestMatch);

                // Populate the results
                const resultContent = document.getElementById('result-content');
                resultContent.innerHTML = `
                    <img src="Assets/${bestMatch.image}" alt="${bestMatch.name}" class="result-image">
                    <h3>${bestMatch.name}</h3>
                    <p class="lead">${bestMatch.description}</p>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Why it's perfect for you:</h5>
                            <ul class="text-start">
                                ${bestMatch.benefits.map(benefit => `<li>${benefit}</li>`).join('')}
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Care tips:</h5>
                            <ul class="text-start">
                                ${bestMatch.care.map(tip => `<li>${tip}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <p>Price Range: ${bestMatch.price}<br>Lasts: ${bestMatch.duration}</p>
                    </div>
                `;

                // Populate other matches
                const otherMatchesContent = document.getElementById('other-matches-content');
                otherMatchesContent.innerHTML = otherMatches.map(match => `
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <img src="Assets/${match.image}" class="card-img-top" alt="${match.name}" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">${match.name}</h5>
                                <p class="card-text small">${match.shortDesc}</p>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Function to determine the best match based on answers
            function determineMatch(answers) {
                const lifestyle = answers['1'] || '';
                const maintenance = answers['2'] || '';
                const length = answers['3'] || '';
                const style = answers['4'] || '';
                const changeFrequency = answers['5'] || '';

                // Define nail services with their characteristics
                const nailStyles = {
                    'classic-manicure': {
                        name: 'Classic Manicure',
                        image: 'classic.jpg',
                        description: 'A timeless, polished look that enhances your natural nails with traditional polish.',
                        benefits: [
                            'Perfect for an active lifestyle',
                            'Minimal maintenance required',
                            'Easy to change colors frequently',
                            'Least damaging to natural nails'
                        ],
                        care: [
                            'Apply a top coat every 2-3 days to extend wear',
                            'Use cuticle oil daily',
                            'Wear gloves for cleaning or gardening'
                        ],
                        price: 'starts at P300',
                        duration: '7-10 days',
                        shortDesc: 'A classic choice for natural nails with traditional polish.',
                        matches: {
                            lifestyle: ['practical', 'balanced'],
                            maintenance: ['minimal'],
                            length: ['short'],
                            style: ['classic', 'natural'],
                            changeFrequency: ['frequent']
                        }
                    },
                    'soft-gel': {
                        name: 'Soft Gel Manicure',
                        image: 'softgel.jpg',
                        description: 'A long-lasting, high-shine finish that cures under a UV/LED lamp for durability.',
                        benefits: [
                            'Lasts 2-3 weeks without chipping',
                            'Perfect glossy finish that doesn\'t dull',
                            'Stronger than regular polish but still flexible',
                            'Wide range of colors and finishes'
                        ],
                        care: [
                            'Avoid harsh chemicals that can break down the gel',
                            'Apply cuticle oil daily to prevent lifting',
                            'Avoid picking or peeling (seek professional removal)'
                        ],
                        price: 'starts at P400',
                        duration: '2-3 weeks',
                        shortDesc: 'Long-lasting, high-shine finish that won\'t chip for weeks.',
                        matches: {
                            lifestyle: ['balanced', 'gentle'],
                            maintenance: ['minimal', 'moderate'],
                            length: ['short', 'medium'],
                            style: ['classic', 'trendy', 'natural'],
                            changeFrequency: ['regular']
                        }
                    },
                    'press-ons': {
                        name: 'Press-On Nails',
                        image: 'pressons.jpg',
                        description: 'Pre-designed, ready-to-wear nail enhancements that can be applied at home or in the salon.',
                        benefits: [
                            'Instant length and design',
                            'Can be removed and reapplied',
                            'No damage to natural nails when applied correctly',
                            'Available in countless designs and shapes'
                        ],
                        care: [
                            'Apply with quality adhesive for longer wear',
                            'Avoid excessive water exposure in the first 24 hours',
                            'Remove gently to preserve your natural nails'
                        ],
                        price: 'starts at P350',
                        duration: '1-2 weeks',
                        shortDesc: 'Instant glam with minimal commitment.',
                        matches: {
                            lifestyle: ['balanced'],
                            maintenance: ['minimal', 'moderate'],
                            length: ['medium', 'long'],
                            style: ['trendy', 'artistic'],
                            changeFrequency: ['frequent', 'regular']
                        }
                    },
                    'builder-gel': {
                        name: 'Builder Gel Extensions',
                        image: 'builder.jpg',
                        description: 'Flexible, natural-feeling extensions that add length while maintaining a natural appearance.',
                        benefits: [
                            'More flexible and natural-feeling than acrylics',
                            'Can be worn at medium or long lengths',
                            'Lightweight and comfortable',
                            'Less damaging to natural nails than some alternatives'
                        ],
                        care: [
                            'Avoid excessive force or pressure on nail tips',
                            'Get fills every 2-3 weeks',
                            'Use cuticle oil daily to maintain flexibility'
                        ],
                        price: 'starts at P500',
                        duration: 'Fill every 2-3 weeks',
                        shortDesc: 'Flexible, natural-feeling extensions for added length.',
                        matches: {
                            lifestyle: ['gentle'],
                            maintenance: ['moderate', 'dedicated'],
                            length: ['medium', 'long'],
                            style: ['classic', 'trendy', 'artistic'],
                            changeFrequency: ['regular', 'occasionally']
                        }
                    },
                    'nail-art': {
                        name: 'Custom Nail Art',
                        image: 'artistic.jpg',
                        description: 'Express your personality with custom designs on gel or builder gel base.',
                        benefits: [
                            'Unlimited creative possibilities',
                            'Can be subtle or statement-making',
                            'Customized to your exact preferences',
                            'Makes a unique fashion statement'
                        ],
                        care: [
                            'Top coat may be needed to preserve intricate designs',
                            'Avoid activities that could chip the art',
                            'Take extra care with 3D elements or embellishments'
                        ],
                        price: 'starts at P600',
                        duration: 'Depends on base (2-4 weeks)',
                        shortDesc: 'Unlimited creative possibilities for unique expression.',
                        matches: {
                            lifestyle: ['gentle'],
                            maintenance: ['moderate', 'dedicated'],
                            length: ['medium', 'long'],
                            style: ['trendy', 'artistic'],
                            changeFrequency: ['regular', 'occasionally']
                        }
                    }
                };

                // Score each style based on how well it matches answers
                let styleScores = {};

                for (const [styleName, styleData] of Object.entries(nailStyles)) {
                    let score = 0;

                    // Check lifestyle match
                    if (styleData.matches.lifestyle.includes(lifestyle)) {
                        score += 2;
                    }

                    // Check maintenance match
                    if (styleData.matches.maintenance.includes(maintenance)) {
                        score += 2;
                    }

                    // Check length match
                    if (styleData.matches.length.includes(length)) {
                        score += 2;
                    }

                    // Check style match
                    if (styleData.matches.style.includes(style)) {
                        score += 3; // Weight style preference higher
                    }

                    // Check change frequency match
                    if (styleData.matches.changeFrequency.includes(changeFrequency)) {
                        score += 2;
                    }

                    styleScores[styleName] = score;
                }

                console.log('Style Scores:', styleScores);

                // Find the style with the highest score
                let bestMatchName = Object.keys(styleScores).reduce((a, b) =>
                    styleScores[a] > styleScores[b] ? a : b
                );

                return nailStyles[bestMatchName];
            }

            // Function to determine other matches
            function determineOtherMatches(bestMatch) {
                // Return complementary styles
                const otherMatches = [{
                        name: 'French Manicure',
                        image: 'french.jpg',
                        shortDesc: 'Classic, elegant look with a natural pink base and white tips.'
                    },
                    {
                        name: 'Chrome Nails',
                        image: 'chrome.jpg',
                        shortDesc: 'Ultra-reflective metallic finish that catches the light beautifully.'
                    },
                    {
                        name: 'Ombré Nails',
                        image: 'ombre.jpg',
                        shortDesc: 'Gradient effect with seamless blending between two or more colors.'
                    }
                ];

                return otherMatches;
            }
  

        });
        document.addEventListener('DOMContentLoaded', function() {
            const servicesLink = document.querySelector('.nav-link');
            servicesLink.addEventListener('click', function() {
                window.location.href = 'services.php';
            });
            const bookNow = document.querySelector('.book-now');
            bookNow.addEventListener('click', function() {
                window.location.href = 'booking.php';
            });
            <?php if ($logged_in): ?>
                const userInitial = document.querySelector('.user-initial');
                userInitial.addEventListener('click', function() {
                    window.location.href = 'members-lounge.php';
                });
            <?php else: ?>
                const loginIcon = document.querySelector('.login-icon');
                loginIcon.addEventListener('click', function() {
                    window.location.href = 'login.php';
                });
            <?php endif; ?>
            });
    </script>
        <?php include 'chat-widget.php'; ?>
</body>

</html>