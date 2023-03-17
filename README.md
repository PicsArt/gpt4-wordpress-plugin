# GPT4 Wordpress Plugin 

This is a Wordpress plugin that uses the [OpenAI](openai.com) GPT-4 API to generate text. It allows users to enter a prompt, select a model and generate text based on the prompt and model selected.

We were thrilled with the power of [ChatGPT](chat.openai.com) – it allowed us to create this free WordPress plugin with just a few tweaks! 80% of the work was already done for us, so it was a breeze to get up and running!

**Benefits of GPT-4:**
- Improved text generation quality
- Faster performance
- Better understanding of context
- Enhanced creativity and versatility
- GPT-4 can take inputs of up to 25,000 words at once, while GPT-3 can only handle 2,048 tokens2. This means that GPT-4 can handle longer and more complex texts2.
- GPT-4 can understand images as well as text, and generate captions or descriptions for them3. This makes it more multimodal and versatile than GPT-34.
- GPT-4 can perform more complex tasks with improved accuracy, scalability, and alignment4. This will allow for a wider range of applications such as language translation, text summarization, and conversational agents45.


## Demo Site
You can check out a demo of the plugin in action on the following site:
- [Demo Site](https://aicreate.com/text-to-text-ai/)

## Features
- **Easy to use interface** with a form that takes a prompt and a model
- **Easy to customize** with the ability to change default parameters such as role, temperature, prefix/post fix to the prompt.

## Installation Instructions
1. Download the plugin files from GitHub. Add API key. 
2. Log in to your Wordpress dashboard and navigate to the "Plugins" section.
3. Click on "Add New" and then "Upload Plugin".
4. Choose the plugin files you just downloaded and click "Install Now".
5. Click on "Activate Plugin"

## Using the plugin

To use the plugin, you will need an API key from OpenAI. You can sign up for one [here](https://beta.openai.com/signup/).

Once you have an API key, you will need to enter it into the php file

To use the plugin in WordPress, the shortcode should be added [chatgpt "prefix" "postfix" "role"] for example [chatgpt prefix="Please help with" postfix="" system_role="You are a helpful AI assistant"].
