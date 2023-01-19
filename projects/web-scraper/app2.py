from bs4 import BeautifulSoup
import os

with open('index.html', 'r') as f:
    html_code = f.read()

soup = BeautifulSoup(html_code, 'html.parser')
question = soup.select_one('.sa-assessment-quiz__title-question span').text

answers = []
for i, answer in enumerate(soup.select('.sa-question-basic-multichoice__multiline')):
    letter = chr(ord('A') + i)
    answers.append(f"{letter}) {answer.text}")

os.remove('file.txt')
with open('file.txt', 'w') as f:
    f.write(question + "\n")
    for answer in answers:
        f.write(answer + "\n")