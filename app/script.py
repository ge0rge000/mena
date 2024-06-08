import socket

def encode_packet_length(length):
    bytes_result = bytearray()
    while True:
        digit = length % 128
        length //= 128
        if length > 0:
            digit |= 0x80
        bytes_result.append(digit)
        if length == 0:
            break
    return bytes_result

def create_connect_packet(client_id):
    payload = bytearray()
    # MQTT Protocol Name
    payload.extend([0x00, 0x04])
    payload.extend("MQTT".encode('utf-8'))
    # MQTT Protocol Level (MQTT 3.1.1)
    payload.append(0x04)
    # Connect Flags: Clean Session
    payload.append(0x02)
    # Keepalive for 60 seconds
    payload.extend([0x00, 0x3C])
    # Client ID encode as UTF-8 strings
    payload.extend([0x00, len(client_id)])
    payload.extend(client_id.encode('utf-8'))

    # Final packet
    packet = bytearray()
    packet.append(0x10)
    packet.extend(encode_packet_length(len(payload)))
    packet.extend(payload)
    return packet

def create_subscribe_packet(topic, packet_id=1):
    payload = bytearray()
    # Packet ID
    payload.extend([0x00, packet_id])
    # Topic and QoS
    payload.extend([0x00, len(topic)])
    payload.extend(topic.encode('utf-8'))
    payload.append(0x00)  # QoS level 0

    # Final packet
    packet = bytearray()
    packet.append(0x82)
    packet.extend(encode_packet_length(len(payload)))
    packet.extend(payload)
    return packet

def create_disconnect_packet():
    packet = bytearray()
    packet.append(0xE0)
    packet.append(0x00)
    return packet

def main():
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        s.connect(("213.192.95.198", 1883))
        try:
            # Send the CONNECT packet
            connect_packet = create_connect_packet("my_client_id")
            s.send(connect_packet)
            response = s.recv(4096)
            if not response.startswith(b'\x20\x02\x00\x00'):
                print("Failed to connect!")
                return

            # Send the SUBSCRIBE packet
            subscribe_packet = create_subscribe_packet("messages/alarm")
            s.send(subscribe_packet)
            response = s.recv(4096)
            if not response.startswith(b'\x90'):
                print("Failed to subscribe!")
                return

            # Waiting for messages (just one for the purpose of this example)
            message = s.recv(4096)
            print("Received:", message)

            # Send DISCONNECT packet
            disconnect_packet = create_disconnect_packet()
            s.send(disconnect_packet)

        except Exception as e:
            print(f"An error occurred: {e}")

if __name__ == "__main__":
    main()
