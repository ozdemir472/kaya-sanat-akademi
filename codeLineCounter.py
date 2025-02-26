import os

def count_lines_of_code(root_dir):
    total_lines = 0
    extensions = ('.php', '.html', '.css', 'js')
    
    for subdir, _, files in os.walk(root_dir):
        for file in files:
            if file.endswith(extensions):
                file_path = os.path.join(subdir, file)
                with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
                    total_lines += len(f.readlines())
    
    return total_lines

project_directory = './' 
print(f"Toplam kod satırı: {count_lines_of_code(project_directory)}")
