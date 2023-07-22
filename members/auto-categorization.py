#!/usr/bin/env python

#Natural Language Processing and ML adapted for library implementation 
#from Text Classification With Python tutorial
#Demonstrated by Richard Gruss: https://www.youtube.com/watch?v=EfEW3_RLnGA&t=34s
#Noted in references of Phase 3 Report

import os
import argparse
import random
import string
import nltk
from nltk import FreqDist, word_tokenize
from nltk.corpus import stopwords
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.naive_bayes import MultinomialNB
from sklearn import metrics
from collections import defaultdict
import pickle

BASE_DIR = 'C:/xampp/htdocs/BookHive/Articles'

LABELS = ['Business', 'Entertainment', 'Politics', 'Sports', 'Tech']

def create_data_set():
    with open('data.txt', 'w', encoding='utf-8') as outfile:
        for label in LABELS:
            dir = os.path.join(BASE_DIR, label)
            for filename in os.listdir(dir):
                fullfilename = os.path.join(dir, filename)
                #print(fullfilename)
                with open(fullfilename, 'rb') as file:
                    for encoding in ['utf-8', 'latin-1', 'utf-16']:
                        try:
                            text = file.read().decode(encoding).replace('\n', '')
                            break
                        except UnicodeDecodeError:
                            continue
                    else:
                        print(f"Cannot decode file: {fullfilename}")
                        continue
                    outfile.write('%s\t%s\t%s\n' % (label, filename, text))

def setup_docs(): 
    docs = []
    with open('data.txt', 'r', encoding='utf-8') as datafile:
        for row in datafile:
            parts = row.split('\t')
            if len(parts) >= 3:
                doc = (parts[0], parts[2].strip())
                docs.append(doc)
            else:
                print(f"Skipping invalid row: {row}")

    return docs

def clean_text(text):
    text = text.translate(str.maketrans('', '', string.punctuation))
    text = text.lower()
    return text

def get_tokens(text):
    stop_words = set(stopwords.words('english'))  # Load the stopwords list
    stop_words.add('said')
    stop_words.add('mr')
    tokens = word_tokenize(text)
    tokens = [t for t in tokens if t not in stop_words]  # Check against the stop words
    return tokens

def print_frequency_dist(docs):
    tokens = defaultdict(list)

    for doc in docs:
        doc_label = doc[0]
        doc_text = clean_text(doc[1])

        doc_tokens = get_tokens(doc_text)
        tokens[doc_label].extend(doc_tokens)

    for category_label, category_tokens in tokens.items():
        print(category_label)
        fd = FreqDist(category_tokens)
        print(fd.most_common(30))

def get_splits(docs):
    random.shuffle(docs)

    # Training docs, corresponding training labels, test docs, corresponding test labels
    X_train, y_train, X_test, y_test = [], [], [], [] 

    pivot = int(.80 * len(docs))

    for i in range(0, pivot): 
        X_train.append(docs[i][1])
        y_train.append(docs[i][0])
    
    for i in range(pivot, len(docs)): 
        X_test.append(docs[i][1])
        y_test.append(docs[i][0])
    
    return X_train, X_test, y_train, y_test

def evaluate_classifier(title, classifier, vectorizer, X_test, y_test): 
    X_test_tfidf = vectorizer.transform(X_test)
    y_pred = classifier.predict(X_test_tfidf)

    precision = metrics.precision_score(y_test, y_pred, average='weighted')
    recall = metrics.recall_score(y_test, y_pred, average='weighted')
    f1 = metrics.f1_score(y_test, y_pred, average='weighted')
    
    #print("%s\t%f\t%f\t%f\n" % (title, precision, recall, f1))


def train_classifier(docs): 
    X_train, X_test, y_train, y_test = get_splits(docs)
    vectorizer = CountVectorizer(stop_words='english', 
                                 ngram_range=(1,3), 
                                 min_df=3, 
                                 analyzer='word')
    
    # Doc-term matrix
    dtm = vectorizer.fit_transform(X_train)

    # Train Naive Bayes classifier
    naive_bayes_classifier = MultinomialNB().fit(dtm, y_train)
    
    evaluate_classifier("Naive Baye \tTRAIN\t", naive_bayes_classifier, vectorizer, X_train, y_train)
    evaluate_classifier("Naive Baye \tTEST\t", naive_bayes_classifier, vectorizer, X_test, y_test)

    # #store the classifier 
    clf_filename = 'naive_bayes_classifier.pkl'
    pickle.dump(naive_bayes_classifier, open(clf_filename, 'wb'))

    # #store the vectorizer so we can transform new data
    vec_filename = 'count_vectorizer.pkl'
    pickle.dump(vectorizer, open(vec_filename, 'wb'))

def classify(text): 
    #load classifier 
    clf_filename = 'naive_bayes_classifier.pkl'
    nb_clf = pickle.load(open(clf_filename, 'rb'))

    #vectorize the new text
    vec_filename = 'count_vectorizer.pkl'
    vectorizer = pickle.load(open(vec_filename, 'rb'))

    pred = nb_clf.predict(vectorizer.transform([text]))

    print((pred[0]).capitalize())

if __name__ == '__main__': 

    #create_data_set()
    nltk.download('punkt')
    nltk.download('stopwords')
    docs = setup_docs()
    #print_frequency_dist(docs)

    train_classifier(docs)
    parser = argparse.ArgumentParser()
    parser.add_argument("input", default="")
    args = parser.parse_args()

    classify(args.input)
