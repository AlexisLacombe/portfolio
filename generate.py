#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Script pour mettre à jour UN SEUL fichier filesX.js
Utile quand vous ajoutez des fichiers dans un dossier spécifique
"""
import os
from datetime import datetime

RUBRIQUES = {
    1: "Travaux Demandés",
    2: "Notes de Cours",
    3: "Documents SI",
    4: "Certifications",
    5: "Projet Final",
    6: "Diaporama Soutenance",
    7: "Autres Ressources"
}

def format_taille(taille_octets):
    """Convertit la taille en octets vers un format lisible"""
    for unite in ['o', 'Ko', 'Mo', 'Go']:
        if taille_octets < 1024.0:
            return f"{taille_octets:.1f} {unite}"
        taille_octets /= 1024.0
    return f"{taille_octets:.1f} To"

def mettre_a_jour_fichier(numero):
    """Met à jour le fichier filesX.js pour la rubrique X"""
    
    if numero not in RUBRIQUES:
        print(f"❌ Erreur : le numéro doit être entre 1 et 7")
        return False
    
    dossier = f"fichiers{numero}"
    fichier_sortie = f"files{numero}.js"
    nom_rubrique = RUBRIQUES[numero]
    
    print()
    print("=" * 70)
    print(f"🔄 Mise à jour : {nom_rubrique}")
    print("=" * 70)
    
    # Vérifier si le dossier existe
    if not os.path.exists(dossier):
        print(f"❌ Erreur : le dossier {dossier}/ n'existe pas")
        return False
    
    # Scanner les fichiers
    fichiers = []
    for item in os.listdir(dossier):
        chemin = os.path.join(dossier, item)
        
        if os.path.isfile(chemin):
            taille = os.path.getsize(chemin)
            date_modif = os.path.getmtime(chemin)
            date_formatee = datetime.fromtimestamp(date_modif).strftime('%d/%m/%Y')
            
            fichiers.append({
                "name": item,
                "size": taille,
                "date": date_formatee,
                "timestamp": date_modif
            })
    
    fichiers.sort(key=lambda x: x['timestamp'], reverse=True)
    
    # Générer le contenu
    contenu = "// ============================================\n"
    contenu += f"// RUBRIQUE : {nom_rubrique}\n"
    contenu += "// LISTE DES FICHIERS - Généré automatiquement\n"
    contenu += f"// Date de génération : {datetime.now().strftime('%d/%m/%Y %H:%M:%S')}\n"
    contenu += f"// Nombre de fichiers : {len(fichiers)}\n"
    contenu += "// ============================================\n\n"
    contenu += "const filesList = [\n"
    
    for i, fichier in enumerate(fichiers):
        contenu += f"  {{ name: \"{fichier['name']}\", size: {fichier['size']}, date: \"{fichier['date']}\" }}"
        if i < len(fichiers) - 1:
            contenu += ","
        contenu += "\n"
    
    contenu += "];\n"
    
    # Écrire le fichier
    with open(fichier_sortie, "w", encoding="utf-8") as f:
        f.write(contenu)
    
    print(f"\n✅ {fichier_sortie} mis à jour avec succès !")
    print(f"📊 {len(fichiers)} fichier(s) trouvé(s) dans {dossier}/\n")
    
    if fichiers:
        print("📄 Liste des fichiers :")
        print("-" * 70)
        for fichier in fichiers:
            print(f"   • {fichier['name']:<40} {format_taille(fichier['size']):>10}  {fichier['date']}")
    else:
        print("⚠️  Aucun fichier trouvé dans le dossier")
    
    print("=" * 70)
    return True

def main():
    print("\n" + "=" * 70)
    print("🔧 MISE À JOUR D'UN FICHIER files.js")
    print("=" * 70)
    print("\nRubriques disponibles :")
    print("-" * 70)
    for num, nom in RUBRIQUES.items():
        print(f"  {num}. {nom}")
    print("-" * 70)
    
    while True:
        try:
            choix = input("\n👉 Entrez le numéro de la rubrique à mettre à jour (1-7) ou 'q' pour quitter : ").strip()
            
            if choix.lower() == 'q':
                print("\n👋 Au revoir !")
                break
            
            numero = int(choix)
            
            if mettre_a_jour_fichier(numero):
                continuer = input("\n✨ Voulez-vous mettre à jour une autre rubrique ? (o/n) : ").strip().lower()
                if continuer != 'o':
                    print("\n👋 Au revoir !")
                    break
        
        except ValueError:
            print("❌ Veuillez entrer un nombre entre 1 et 7")
        except KeyboardInterrupt:
            print("\n\n👋 Au revoir !")
            break

if __name__ == "__main__":
    main()