from io import BytesIO
from flask import Flask, jsonify, request, send_file
from PIL import Image
import requests
import qrcode
import re

app = Flask(__name__)

@app.route('/generate', methods=['POST', 'GET'])
def generate_qr_code():
    hex_color_re = re.compile(r'^#(?:[0-9a-fA-F]{3}){1,2}$')

    if request.method == 'POST':
        data = request.json['data']
        format = request.json.get('format', 'png')
        logo = request.json.get('logo', None)
        color = request.json.get('color', {"fill_color":"#000000","back_color":"#FFFFFF"})

    elif request.method == 'GET':
        data = request.args.get('data')
        format = request.args.get('format', 'png')
        logo = request.args.get('logo', None)
        color = request.args.get('color', {"fill_color":"#000000","back_color":"#FFFFFF"})

    # Validate Hex Color
    if not hex_color_re.match(color["fill_color"]):
        return jsonify(error=f"Invalid fill_color : {color['fill_color']}"), 400
    if not hex_color_re.match(color["back_color"]):
        return jsonify(error=f"Invalid back_color : {color['back_color']}"), 400

    # create QR code image
    qr = qrcode.QRCode(version=1, box_size=10, border=5)
    qr.add_data(data)
    qr.make(fit=True)
    img = qr.make_image(fill_color=color["fill_color"], back_color=color["back_color"])

    if logo:
        try:
            if "http" in logo:
                # Open the logo image and resize it from url
                response = requests.get(logo)
                response.raise_for_status()
                logo_img = Image.open(BytesIO(response.content))
                logo_img = logo_img.resize((75, 75))
            else:
                # Open logo image and resize it from base64
                logo_img = Image.open(BytesIO(logo))
                logo_img = logo_img.resize((75, 75))

            # paste logo image in the center of QR code
            img_w, img_h = img.size
            logo_w, logo_h = logo_img.size
            img.paste(logo_img, ((img_w - logo_w)//2, (img_h - logo_h)//2))
        except requests.exceptions.HTTPError as e:
            return jsonify(error=f"Error in getting logo from url {logo} : {e}"), 404
        except requests.exceptions.RequestException as e:
            return jsonify(error=f"Error in getting logo from url {logo} : {e}"), 500
        except Exception as e:
            return jsonify(error=f"Error in processing logo {logo} : {e}"), 500
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
