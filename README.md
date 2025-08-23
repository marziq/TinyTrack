<p align="center"><a href="" target="_blank"><img src="public/img/Untitled design.png" width="400" alt="TinyTrack Logo"></a></p>

## About TinyTrack

<p align="justify">The TinyTrack: Digital Baby Wellness and Growth Platform is designed to address the challenges faced by parents in monitoring the early development stages of their children. The purpose of this project is to develop a user-friendly, web-based system that centralizes and simplifies baby wellness management. TinyTrack aims to assist Malaysian parents by integrating automated tools and features into a single platform to support the tracking of baby wellness metrics such as height, weight, medical check-up schedules and developmental milestones. The platform offers parents with timely reminders, parenting tips and educational resources and easy-to-understand data visualizations, empowering parents to take proactive steps in managing their baby's health and development. In addition, this project supports the United Nations Sustainable Development Goal 3: Good Health and Well-Being by promoting early detection of potential health issues through regular tracking of a baby’s growth and development. Therefore, by enabling parents to monitor wellness metrics and receive health-related guidance, TinyTrack aspires to contribute to healthier early childhood outcomes and foster informed parenting practices.</p>

## Developers Logs

### Saturday 23 August 2025

<p align="justify">We implemented the AI on Growth page to give advice/recommendation to parent if their baby is growing not normal. We also decided to try new model which is DeepSeek: R1 Distill Llama 70B. We will continue further test to ensure stability of the AI</p>

### Friday 22 August 2025

<p align="justify">We are still undergo few experiments on API for our Sage Chatbot. Currently we use Llama 3.3 70B Instruct. Previous Sage we implement doesnt remember last conversation making it feels not natural. We figured out the way for Sage to remember the last conversation but we also found new problem which the more Sage remember last conversation, more times needed for respond to prompt. We decide to limit the conversation that Sage remember to last 10 conversation. Not long after that, we have idea instead of only remembers 10 conversation, if the conversations getting long the system will asked to summarize the convesations and then continue answering to user prompt</p>

## Development Updates

### Saturday 23 August 2025

- Implemented Zscores Calculation for for Height and Weight in order to classified the baby growth is normal or not
- Implemented AI Recommendation for parents if their baby's growth isn't normal.

### Friday 22 August 2025

- Improved Chatbot Response (Remember last conversation)

### Thursday 21 August 2025

- Implemented Notifications Bell functionality for user-side page
- Added Chatbot Page (Pseudo Design)
- Added Test Chatbot (Model Llama 3.3 70B Instruct (free))


## TinyTrack Developers
- Ammar Haziq Bin Zainal
- Arina Batrisyia Bint Mohd Razali

## Security Vulnerabilities

If you discover a security vulnerability within  TinyTrack, please send an e-mail to Ammar Haziq via [ammarhaziqzainal@gmail.com](mailto:ammarhaziqzainal@gmail.com). All security vulnerabilities will be promptly addressed.

## License

TinyTrack used Laravel framework. Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
