#mise en place de l'algorithme de chiffrement par décalage (ou chiffre césar)
#en fournissant un texte et une clé, renvoyer un message codé 
#en décalant dans l'alphabet chaque lettre d'un nombre de lettre correspondant à la clé fournie

#gen alphabet doit renvoyer toutes les lettres minuscules de l'alphabet, 
# suivi de toutes les lettres majuscules
# suivi d'un espace, d'une virgule, d'un point, d'un tiret, d'un tilde, et d'un dièse
from string import ascii_letters
def genAlphabet(): 
    return ascii_letters+" ,.-~#"

#doit chiffrer par décalage un message et renvoyer le message chiffré&
def caesarEncrypt(message, key):
    encrypted = ""
    alphabet = genAlphabet()
    if (key % len(alphabet)) == 0:
        return "erreur : clé inutile"
    for ch in message:
        index = alphabet.find(ch) + key
        encrypted += alphabet[index % len(alphabet)]
    return encrypted

#doit déchiffrer un message chiffré par décalage et renvoyer le message déchiffré 
def caesarDecrypt(message, key):
    return caesarEncrypt(message, -key)

print(caesarDecrypt(caesarEncrypt("Salut les amis", 6), 6))

#amélioration ridicule de notre algorithme de chiffrement
#on introduit une variabilité de notre permutation de symboles 
#en se basant sur une clé binaire générée depuis la clé de permutation
#puis on effectue chaque permutation en se basant sur un bit de la clé binaire 
#un 1 effectue une permutation vers "l'avant" de l'alphabet
#un 0 effectue une permutation vers "l'arrière" de l'alphabet
#on boucle sur cette clé binaire à l'infini tant qu'on a pas permuté toutes les lettres

#la fonction genBinKey génère une clé binaire à partir d'une clé sous la forme d'int
def genBinKey(key):
    bin_key = bin(key)[2:]
    return bin_key

def binCaesarEncrypt(message, key):
    alphabet = genAlphabet()
    bin_key = genBinKey(key)
    encrypted = ""
    i = 0
    for letter in message:
        index = alphabet.find(letter)
        index += key if bin_key[i] == 1 else -key
        encrypted+=alphabet[index % len(alphabet)]
        i+=1            
    return encrypted

def binCaesarDecrypt(message, key):
    alphabet = genAlphabet()
    bin_key = genBinKey(key)
    encrypted = ""
    i = 0
    for letter in message:
        if bin_key[i%len(bin_key)] == 1:
            index = alphabet.find(letter) - key
        else:
            index = alphabet.find(letter) + key
        encrypted+=alphabet[index % len(alphabet)]
        i+=1            
    return encrypted

print(genBinKey(5))
print(binCaesarDecrypt(binCaesarEncrypt("salut les enfants", 5), 5))
