import requests

response = requests.post('http://127.0.0.1:8000/api/test')

print(response.status_code)