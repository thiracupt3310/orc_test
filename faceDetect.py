#!/usr/bin/python3

import cv2
import sys
import base64
import numpy as np


# Get user supplied values
# imagePath = sys.argv[1]

# f = open("/var/www/html/orc_test/storage/app/public/base64/base64.txt", "r")
# im_bytes = base64.b64decode(f.read())
# im_arr = np.frombuffer(im_bytes, dtype=np.uint8)
image = cv2.imread(
    "/var/www/html/orc_test/storage/app/public/base64/imageCard.jpg")
# image = cv2.imread("../storage/app/public/base64/imageCard.jpg")
# image = cv2.imread("http://face.ksta.co/storage/base64/imageCard.jpg")


# print(f.read())


# Create the haar cascade
faceCascade = cv2.CascadeClassifier(
    cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

# Read the image
# image = cv2.imread(imagePath)


gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
# print(base64.b64encode(image))

# # Detect faces in the image
faces = faceCascade.detectMultiScale(
    gray,
    scaleFactor=1.1,
    minNeighbors=5,
    minSize=(30, 30),
    # flags = cv2.CASCADE_SCALE_IMAGE
)


# Draw a rectangle around the faces
index = 0
maxH = 0
indexMax = 0
imageList = []
for (x, y, w, h) in faces:
    # cv2.rectangle(image, (x, y), (x+w, y+h), (0, 255, 0), 2)

    if h > maxH:
        maxH = h
        indexMax = index
    margin = h * 0.35
    y_start = int(y - margin)
    y_end = int(y+h + margin)
    x_start = int(x - margin)
    x_end = int(x+w + margin)

    crop_img = image[y_start:y_end, x_start:x_end]
    imageList.append(crop_img)
    # cv2.imshow("cropped_" + str(index), crop_img)
    index += 1

if maxH != 0:

    # cv2.imwrite(
    #     "/var/www/html/orc_test/storage/app/public/base64/imageCard_crop.jpg", imageList[indexMax])
    # im_arr: image in Numpy one-dim array format.
    _, im_arr = cv2.imencode('.jpg', image)
    im_bytes = im_arr.tobytes()
    im_b64 = base64.b64encode(im_bytes)
    print(im_b64)


# cv2.waitKey(0)
