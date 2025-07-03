import datetime
import os
import time

import mysql.connector
import argparse
import openai

try:
    parser = argparse.ArgumentParser(formatter_class=argparse.ArgumentDefaultsHelpFormatter)
    parser.add_argument("--host", "--h")
    parser.add_argument("--port", "--p")
    parser.add_argument("--password", "--pw")
    parser.add_argument("--user", "--u")
    parser.add_argument("--dbname", "--dbn")

    parser.add_argument("--open-api-key", "-key-openapi")

    args = parser.parse_args()
    config = vars(args)

    OPEN_API_KEY = config.get("open_api_key")
    openai.api_key = OPEN_API_KEY

    mydb = mysql.connector.connect(
        host=config.get("host"),
        user=config.get("user"),
        password=config.get("password"),
        port=config.get("port"),
        database=config.get("dbname")
    )

    cursor = mydb.cursor()

    query = "SELECT * FROM question_answers"
    cursor.execute(query)
    result = cursor.fetchall()

    dataset = [[], []]

    for r in result:
        dataset[0].append(str(r[1]))
        dataset[1].append(str(r[2]))

    # Step 2 Convert data to jsonl
    eof = "\n\n"
    length = len(dataset[0])

    if not os.path.exists("train_file"):
        os.mkdir("train_file")

    file_name = "train_file/train" + datetime.datetime.now().strftime("%m-%d-%Y_%H:%M:%S") + ".jsonl"
    # length = 10
    test_file = open(file_name, "a")
    for i in range(0, length):
        sep_open = "{"
        sep_close = "}"
        test_file.write(f'{sep_open}"prompt": "{dataset[0][i]}\\n\\n", "completion": "{dataset[1][i]}\\n\\n"{sep_close}\n')
    test_file.close()

    time.sleep(2)

    res_file = openai.File.create(
        file=open(file_name, "rb"),
        purpose='fine-tune'
    )
    res_fine_tune = openai.FineTune.create(training_file=res_file["id"], model='ada',
                                           suffix='train-' + datetime.datetime.now().strftime("%m-%d-%Y_%H:%M:%S"))
    print(res_fine_tune["id"])
    mydb.close()
except Exception as e:
    print(e)
