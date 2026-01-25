import binascii

class FunLib:
    def bytesToHex(self, bytes):
        return ''.join(f"{byte:02x}" for byte in bytes)

    def stringToUTF8Bytes(self, string):
        return string.encode('utf-8')

    def hexToBytes(self, hex):
        return bytes.fromhex(hex)

    def bin2hex(self, string):
        return self.bytesToHex(self.stringToUTF8Bytes(string))

    def hex2bin(self, hexstring):
        return self.hexToBytes(hexstring).decode('utf-8')

