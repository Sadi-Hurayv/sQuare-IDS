import numpy as np
import pandas as pd
from sklearn.preprocessing import StandardScaler
from sklearn.tree import DecisionTreeClassifier
# from lightgbm import LGBMClassifier
import pickle
import sys

import warnings
warnings.filterwarnings("ignore")

column_names = ['Dst Port', 'Protocol', 'Bwd Pkt Len Min', 'Flow Byts/s',
                'Fwd IAT Mean', 'Fwd IAT Min', 'Bwd IAT Tot', 'Bwd IAT Std',
                'Bwd IAT Max', 'Bwd IAT Min', 'Fwd PSH Flags', 'Fwd URG Flags',
                'Fwd Pkts/s', 'Bwd Pkts/s', 'Pkt Len Min', 'Pkt Len Std', 'Pkt Len Var',
                'FIN Flag Cnt', 'PSH Flag Cnt', 'ACK Flag Cnt', 'URG Flag Cnt',
                'ECE Flag Cnt', 'Down/Up Ratio', 'Fwd Seg Size Avg', 'Bwd Seg Size Avg',
                'Subflow Bwd Byts', 'Init Fwd Win Byts', 'Init Bwd Win Byts',
                'Fwd Act Data Pkts', 'Fwd Seg Size Min', 'Active Std', 'Active Max',
                'Active Min', 'Idle Max', 'Idle Min']

numeric_cols = ['Bwd Pkt Len Min', 'Flow Byts/s',
                'Fwd IAT Mean', 'Fwd IAT Min', 'Bwd IAT Tot', 'Bwd IAT Std',
                'Bwd IAT Max', 'Bwd IAT Min', 'Fwd PSH Flags', 'Fwd URG Flags',
                'Fwd Pkts/s', 'Bwd Pkts/s', 'Pkt Len Min', 'Pkt Len Std', 'Pkt Len Var',
                'FIN Flag Cnt', 'PSH Flag Cnt', 'ACK Flag Cnt', 'URG Flag Cnt',
                'ECE Flag Cnt', 'Down/Up Ratio', 'Fwd Seg Size Avg', 'Bwd Seg Size Avg',
                'Subflow Bwd Byts', 'Init Fwd Win Byts', 'Init Bwd Win Byts',
                'Fwd Act Data Pkts', 'Fwd Seg Size Min', 'Active Std', 'Active Max',
                'Active Min', 'Idle Max', 'Idle Min']


data = np.array(sys.argv[1:36])
data = data.reshape(1, -1)
instance = pd.DataFrame(data, columns=column_names)

# result = {"A": 'a', "B": "Malicious"}
# print(.astype(int))
# print (instance)
# print(instance.info())


def fixDataType(df):

    df['Dst Port'] = df['Dst Port'].astype(int)
    df['Protocol'] = df['Protocol'].astype(int)
    df['Bwd Pkt Len Min'] = df['Bwd Pkt Len Min'].astype(int)
    df['Flow Byts/s'] = df['Flow Byts/s'].astype(float)
    df['Fwd IAT Mean'] = df['Fwd IAT Mean'].astype(float)
    df['Fwd IAT Min'] = df['Fwd IAT Min'].astype(int)
    df['Bwd IAT Tot'] = df['Bwd IAT Tot'].astype(int)
    df['Bwd IAT Std'] = df['Bwd IAT Std'].astype(float)
    df['Bwd IAT Max'] = df['Bwd IAT Max'].astype(int)
    df['Bwd IAT Min'] = df['Bwd IAT Min'].astype(int)
    df['Fwd PSH Flags'] = df['Fwd PSH Flags'].astype(int)
    df['Fwd URG Flags'] = df['Fwd URG Flags'].astype(int)
    df['Fwd Pkts/s'] = df['Fwd Pkts/s'].astype(float)
    df['Bwd Pkts/s'] = df['Bwd Pkts/s'].astype(float)
    df['Pkt Len Min'] = df['Pkt Len Min'].astype(int)
    df['Pkt Len Std'] = df['Pkt Len Std'].astype(float)
    df['Pkt Len Var'] = df['Pkt Len Var'].astype(float)
    df['FIN Flag Cnt'] = df['FIN Flag Cnt'].astype(int)
    df['PSH Flag Cnt'] = df['PSH Flag Cnt'].astype(int)
    df['ACK Flag Cnt'] = df['ACK Flag Cnt'].astype(int)
    df['URG Flag Cnt'] = df['URG Flag Cnt'].astype(int)
    df['ECE Flag Cnt'] = df['ECE Flag Cnt'].astype(int)
    df['Down/Up Ratio'] = df['Down/Up Ratio'].astype(int)
    df['Fwd Seg Size Avg'] = df['Fwd Seg Size Avg'].astype(float)
    df['Bwd Seg Size Avg'] = df['Bwd Seg Size Avg'].astype(float)
    df['Subflow Bwd Byts'] = df['Subflow Bwd Byts'].astype(int)
    df['Init Fwd Win Byts'] = df['Init Fwd Win Byts'].astype(int)
    df['Init Bwd Win Byts'] = df['Init Bwd Win Byts'].astype(int)
    df['Fwd Act Data Pkts'] = df['Fwd Act Data Pkts'].astype(int)
    df['Fwd Seg Size Min'] = df['Fwd Seg Size Min'].astype(int)
    df['Active Std'] = df['Active Std'].astype(float)
    df['Active Max'] = df['Active Max'].astype(int)
    df['Active Min'] = df['Active Min'].astype(int)
    df['Idle Max'] = df['Idle Max'].astype(int)
    df['Idle Min'] = df['Idle Min'].astype(int)

    return df


def normalize(df):
    # Load the scaler object
    with open('/media/shuvra/New Volume/IIT/IIT-SE/8th Semester/Research Project/Tool/sQuareIDS/public/assets/python/binaryScaler.pkl', 'rb') as file:
        scaler = pickle.load(file)

    df[numeric_cols] = scaler.fit_transform(df[numeric_cols])
    return df


def predictInstance(df):
    # Load the model
    with open('/media/shuvra/New Volume/IIT/IIT-SE/8th Semester/Research Project/Tool/sQuareIDS/public/assets/python/binaryModel.pkl', 'rb') as file:
        model = pickle.load(file)

    prediction = model.predict(instance)
    return prediction


instance = fixDataType(instance)
instance = normalize(instance)
prediction = predictInstance(instance)
# print(prediction)

result = {0: "Benign", 1: "Malicious"}
print(result[prediction[0]])
