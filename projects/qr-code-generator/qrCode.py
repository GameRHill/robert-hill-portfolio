from io import BytesIO
from flask import Flask, make_response, jsonify, request, send_file
from qrcode import QRCode

app = Flask(__name__)

@app.route('/generate', methods=['POST'])
def generate_qr_code():
    data = request.json['data']
    format = request.json.get('format', 'png')
    qr = QRCode(version=1, box_size=10, border=5)
    qr.add_data(data)
    qr.make(fit=True)
    img = qr.make_image(fill_color="black", back_color="white")

    if format == 'png':
        img_io = BytesIO()
        img.save(img_io, format='PNG')
        img_io.seek(0)
        return send_file(img_io, mimetype='image/png')
    elif format == 'jpeg':
        img_io = BytesIO()
        img.save(img_io, format='JPEG')
        img_io.seek(0)
        return send_file(img_io, mimetype='image/jpeg')
    elif format == 'svg':
        img_io = BytesIO()
        img.save(img_io, format='SVG')
        img_io.seek(0)
        return send_file(img_io, mimetype='image/svg+xml')
    else:
        return jsonify(error="Invalid format"), 400

if __name__ == '__main__':
    app.run(debug=True)