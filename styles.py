import os

files = os.walk("./css")

for file in files:
    (dirname, _, filenames) = file

    for filename in filenames:
        print(f'<link rel="stylesheet" href="{dirname}/{filename}" />')
